<?php

require 'environment.php';
require 'code/require.php';

$timePeriods = TimePeriod::all_time_periods();

$initialFundEntry = new AmountEntry();
$initialFundEntry->timePeriod = $timePeriods[0];
$initialFundEntry->amount = 40;

$randToFundEntry = new AmountEntry();
$randToFundEntry->timePeriod = $timePeriods[3];
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
echo $tableFormatter->buildTable($startingFundStore, array_slice($timePeriods, 1), $valueFormatter, $months);
echo $tableFormatter->buildTable($newFundStore, array_slice($timePeriods, 1), $valueFormatter, $months);
echo $tableFormatter->buildTable($toFundStore, array_slice($timePeriods, 1), $valueFormatter, $months);
