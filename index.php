<?php

require 'environment.php';
require 'code/require.php';

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
