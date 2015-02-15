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
         $entry = $summed->anyItemForTimePeriod($timePeriod);
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
            $lastEntry = $summed->anyItemForTimePeriod($timePeriod->LastPeriod());
            $entry->amount += $lastEntry->amount;
         }

      });

      return $summed;
   }

   /**
    * For each TimePeriod in $timePeriods, add the value of all the AmountEntrys
    * together into a new AmountEntry. Store that new entry into the store that
    * will be returned.
    *
    * @param $originalItemStore TemporalItemStore - Source for values
    * @param $timePeriods Array of TimePeriods
    * @return array
    */
   public function sumEntriesByTimePeriod($originalItemStore, $timePeriods) {
      return array_reduce($timePeriods, function($store, $timePeriod) use ($originalItemStore) {
         $items = $originalItemStore->itemsForTimePeriod($timePeriod);

         // If no items, don't bother trying to create an entry for the time period
         if (count($items) == 0) {
            return $store;
         };

         // Generate sum of entries
         $summedEntry = array_reduce($items, function ($totalEntry, $entry) {
            $totalEntry->amount += $entry->amount;
            return $totalEntry;
         }, new AmountEntry());
         $summedEntry->timePeriod = $timePeriod;

         // Save sum
         $store->storeItem($summedEntry);
         return $store;
      }, new TemporalItemStore());
   }

}
