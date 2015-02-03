<?php

require 'environment.php';
require 'code/require.php';




// ##########################################
// Fetch Income data
// ##########################################

$incomeData = json_decode(file_get_contents('test_income.json'), true);
$incomeStore = new TemporalItemStore();
$incomeFactory = new IncomeEntryFactory();

array_walk($incomeData, function($item) use ($incomeStore, $incomeFactory){
   $incomeStore->storeItem($incomeFactory->buildEntry($item));
});

$incomeItems = $incomeStore->allItems();

// Sort income items by date
usort($incomeItems, function($a, $b) {
   if ($a->date == $b->date) {
      return 0;
   }
   return (strtotime($a->date) < strtotime($b->date)) ? -1 : 1;
});




// ##########################################
// Print income item list
// ##########################################

$tableFormatter = new ItemStoreTableFormatter();
echo $tableFormatter->buildListTableOfEntries($incomeItems, new IncomeEntrySummaryFormatter(), array('date', 'source', 'amount'));




// ##########################################
// Income summary calculation
// ##########################################

$incomeSourceData = json_decode(file_get_contents('test_income_sources.json'), true);

// TODO: Should income sources have there own data type to include name data?
// TODO: We may want a version of TemporalItemStore that has an id param

$sources = array_reduce($incomeSourceData, function ($carry, $item) {
   $sourceStore = new TemporalItemStore();
   $sourceStore->id = $item['id'];

   array_walk(TimePeriod::all_time_periods(), function($timePeriod) use ($sourceStore){
      $entry = new AmountEntry();
      $entry->timePeriod = $timePeriod;
      $entry->amount = 0;
      $sourceStore->storeItem($entry);
   });

   $carry[$item['name']] = $sourceStore;
   return $carry;
}, array());

array_walk($sources, function($sourceStore) use ($incomeStore) {
   array_walk(TimePeriod::all_time_periods(), function($timePeriod) use ($incomeStore, $sourceStore) {
      $incomeItemsForPeriod = $incomeStore->itemsForTimePeriod($timePeriod);
      $sourceEntry = $sourceStore->anyItemForTimePeriod($timePeriod);

      $sourceEntry->amount = array_reduce($incomeItemsForPeriod, function ($carry, $item) use ($sourceStore) {
         if ($item->source == $sourceStore->id) {
            return $carry + $item->amount;
         }

         return $carry;
      }, 0);
   });
});




// ##########################################
// Print income summary
// ##########################################

$valueFormatter = new SingleAmountEntryOutputFormatter("$%.2f");
$months = array_reduce(TimePeriod::all_time_periods(), function($carry, $timePeriod) {
   // Skip 'Initial' time period
   if ($timePeriod->LastPeriod() == null) {
      return $carry;
   }

   $carry[] = $timePeriod->name;
   return $carry;
}, array(''));
echo $tableFormatter->buildTableByTimePeriod($sources, array_slice(TimePeriod::all_time_periods(), 1), $valueFormatter, $months);




// ##########################################
// Sum all incomes by month
// ##########################################
$incomeTotals = new TemporalItemStore();

array_walk($incomeStore->allItems(), function ($item) use ($incomeTotals) {
   $storedTotalEntry = $incomeTotals->anyItemForTimePeriod($item->timePeriod);
   if (!$storedTotalEntry) {
      $storedTotalEntry = new AmountEntry();
      $storedTotalEntry->timePeriod = $item->timePeriod;
      $incomeTotals->storeItem($storedTotalEntry);
   }

   $storedTotalEntry->amount += $item->amount;
});

echo $tableFormatter->buildTableByTimePeriod(array("total income" => $incomeTotals), array_slice(TimePeriod::all_time_periods(), 1), $valueFormatter, $months);




// ##########################################
// Income routing totals
// ##########################################
$incomeRoutingData = json_decode(file_get_contents('test_income_to_fund_routing.json'), true);
$incomeRoutingStore = new TemporalItemStore();

array_walk($incomeRoutingData, function($item) use ($incomeRoutingStore){
   $entry = new AmountEntry();
   $entry->amount = $item['amount'];
   $entry->fund = $item['fund'];
   $entry->timePeriod = TimePeriod::findTimePeriodWithID(TimePeriod::all_time_periods(), $item['timeperiod']);
   $incomeRoutingStore->storeItem($entry);
});

$routingTotalsStore = new TemporalItemStore();

array_map(function($timePeriod) use ($incomeRoutingStore, $routingTotalsStore) {
   $entry = new AmountEntry();
   $entry->timePeriod = $timePeriod;

   $entry->amount = array_reduce($incomeRoutingStore->itemsForTimePeriod($timePeriod), function($carry, $item) use ($timePeriod) {
      return $carry + $item->amount;
   }, 0);

   $routingTotalsStore->storeItem($entry);
}, TimePeriod::all_time_periods());

echo $tableFormatter->buildTableByTimePeriod(array("routing" => $routingTotalsStore), array_slice(TimePeriod::all_time_periods(), 1), $valueFormatter, $months);




// ##########################################
// Fund changes from routing
// ##########################################
$fundRoutingTotals = array_reduce(TimePeriod::all_time_periods(), function($fundTotals, $timePeriod) use ($incomeRoutingStore) {
   $foundFundTotals = array_reduce($incomeRoutingStore->itemsForTimePeriod($timePeriod), function($carry, $item) use ($timePeriod) {
      $fund = $item->fund;
      $store = $carry[$fund];

      if (!$store) {
         $store = new TemporalItemStore();
         $carry[$fund] = $store;
      }

      $entry = $store->anyItemForTimePeriod($timePeriod);
      if (!$entry) {
         $entry = new AmountEntry();
         $entry->timePeriod = $timePeriod;
         $store->storeItem($entry);
      }

      $entry->amount += $item->amount;

      return $carry;
   }, $fundTotals);

   $newFundTotals = array();
   array_walk(array_keys($fundTotals), function($key) use ($fundTotals, $foundFundTotals, $newFundTotals) {
      $originalTotal = $fundTotals[$key];
      $newTotal = $foundFundTotals[$key];

      if ($newTotal) {
         $combinedTotal = $originalTotal;
         $combinedTotal->amount += $newTotal->amount;

         $newFundTotals[$key] = $combinedTotal;
         return;
      }

      $newFundTotals[$key] = $originalTotal;
   });
   $newFundTotals = array_merge($newFundTotals, $foundFundTotals);

   return $newFundTotals;
}, array());



echo $tableFormatter->buildTableByTimePeriod($fundRoutingTotals, array_slice(TimePeriod::all_time_periods(), 1), $valueFormatter, $months);









exit();



$timePeriods = TimePeriod::all_time_periods();

$initialFundEntry = new IncomeEntry();
$initialFundEntry->timePeriod = $timePeriods[0];
$initialFundEntry->amount = 40;

$randToFundEntry = new IncomeEntry();
$randToFundEntry->timePeriod = $timePeriods[3];
$randToFundEntry->source = 'money';
$randToFundEntry->date = '3/3';
$randToFundEntry->amount = 30;

$toFundStore = new TemporalItemStore(
   array(
      $initialFundEntry,
      $randToFundEntry
      )
   );

$startingFundStore = new TemporalItemStore(array());
$amountCalculate = new AmountCalculate();
$newFundStore = $amountCalculate->sumAmountsToStore($startingFundStore, $toFundStore, $timePeriods);

$fundList = array(
   'fund a' => $newFundStore,
   'fund b' => $newFundStore,
   );

$tableFormatter = new ItemStoreTableFormatter();
$valueFormatter = new SingleAmountEntryOutputFormatter("$%.2f");
$months = array_reduce($timePeriods, function($carry, $timePeriod) {
   // Skip 'Initial' time period
   if ($timePeriod->LastPeriod() == null) {
      return $carry;
   }

   $carry[] = $timePeriod->name;
   return $carry;
}, array(''));
$entries = array($randToFundEntry);
echo $tableFormatter->buildListTableOfEntries($entries, new IncomeEntrySummaryFormatter(), array('date', 'source', 'amount'));
echo $tableFormatter->buildTableByTimePeriod(array($startingFundStore), array_slice($timePeriods, 1), $valueFormatter, $months);
echo $tableFormatter->buildTableByTimePeriod($fundList, array_slice($timePeriods, 1), $valueFormatter, $months);
echo $tableFormatter->buildTableByTimePeriod(array($toFundStore), array_slice($timePeriods, 1), $valueFormatter, $months);
