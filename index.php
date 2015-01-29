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




// Income summary

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
