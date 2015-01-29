<?php

require 'environment.php';
require 'code/require.php';





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


// Income item list
$tableFormatter = new ItemStoreTableFormatter();
echo $tableFormatter->buildListTableOfEntries($incomeItems, new IncomeEntrySummaryFormatter(), array('date', 'source', 'amount'));


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
