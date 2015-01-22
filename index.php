<?php

require 'environment.php';
require 'code/require.php';

$timePeriods = TimePeriod::all_time_periods();

$factory = new IncomeEntryFactory();
$incomeItems = array();

$incomeItems[] = $factory->buildEntry(array(
   'id' => '1',
   'amount' => 45.00,
   'date' => '1/5',
   'notes' => '',
   'source' => 'misc',
   ));
$incomeItems[] = $factory->buildEntry(array(
   'id' => '2',
   'amount' => 45.00,
   'date' => '1/5',
   'notes' => '',
   'source' => 'interest',
   ));
$incomeItems[] = $factory->buildEntry(array(
   'id' => '3',
   'amount' => 45.00,
   'date' => '3/5',
   'notes' => '',
   'source' => 'misc',
   ));

$incomeStore = new TemporalItemStore($incomeItems);
$incomeCalculate = new IncomeCalculate();

array_walk($timePeriods, function($timePeriod) use ($incomeStore, $incomeCalculate) {
   // Skip 'Initial' time period
   if ($timePeriod->LastPeriod() == null) {
      return;
   }

   $entries = $incomeStore->itemsForTimePeriod($timePeriod);
   $total = $incomeCalculate->totalOfEntries($entries);;
   echo "{$timePeriod->name}: \${$total} <br>";
});
