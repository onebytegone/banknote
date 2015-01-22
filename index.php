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

$fundStore = new TemporalItemStore(array());

array_walk($timePeriods, function($timePeriod) use ($fundStore, $toFundStore) {
   $entry = new AmountEntry();
   $entry->timePeriod = $timePeriod;

   // Add to fund if have entry to add
   $toFundEntry = $toFundStore->firstItemForTimePeriod($timePeriod);
   if ($toFundEntry) {
      $entry->amount = $toFundEntry->amount;
   }

   // Add from last time period if possible
   if ($timePeriod->LastPeriod()) {
      $lastEntry = $fundStore->firstItemForTimePeriod($timePeriod->LastPeriod());
      $entry->amount += $lastEntry->amount;
   }

   $fundStore->storeItem($entry);
});


array_walk($timePeriods, function($timePeriod) use ($fundStore) {
   // Skip 'Initial' time period
   if ($timePeriod->LastPeriod() == null) {
      return;
   }

   $entry = $fundStore->firstItemForTimePeriod($timePeriod);
   echo "{$timePeriod->name}: \${$entry->amount} <br>";
});

