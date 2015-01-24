<?php

/**
 * Calculations regarding AmountEntry objects
 *
 * @copyright 2015 Ethan Smith
 */

class AmountCalculate {

   /**
    * Sums the contents of two TemporalItemStores based on TimePeriod. Returns
    * a new TemporalItemStore with the results.
    *
    * NOTE: While $baseStore can have more than one AmountEntry for a TimePeriod,
    *       this may cause issues because the value from the $storeToAdd entry
    *       will only be added to one entry of the TimePeriod in $baseStore.
    *
    * @param $baseStore TemporalItemStore - Store with AmountEntrys to add to
    * @param $storeToAdd TemporalItemStore - Souce for AmountEntrys to add from
    * @return $summed TemporalItemStore - Summed values for TimePeriod
    */
   public function sumAmountsToStore($baseStore, $storeToAdd, $timePeriods) {
      if (!$baseStore) {
         $summed = new TemporalItemStore(array());
      } else {
         $summed = clone $baseStore;  // We need to clone this so $baseStore is not modified
      }

      array_walk($timePeriods, function($timePeriod) use ($summed, $storeToAdd) {
         $entry = $summed->firstItemForTimePeriod($timePeriod);
         if (!$entry) {
            // AmountEntry doesn't exist, create it
            $entry = new AmountEntry();
            $entry->timePeriod = $timePeriod;
            $summed->storeItem($entry);
         }

         // Add to entry if have entry to add
         $toAddEntries = $storeToAdd->itemsForTimePeriod($timePeriod);
         array_walk($toAddEntries, function($item) use ($entry) {
            $entry->amount += $item->amount;
         });


         // Add from last time period if possible
         if ($timePeriod->LastPeriod()) {
            $lastEntry = $summed->firstItemForTimePeriod($timePeriod->LastPeriod());
            $entry->amount += $lastEntry->amount;
         }

      });

      return $summed;
   }

}
