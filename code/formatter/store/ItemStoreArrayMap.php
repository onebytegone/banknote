<?php

/**
 * Generates basic array data for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreArrayMap {
   public $filterEmptyItems = false;

   /**
    *
    * Output:
    * {
    *    'jan': [ AmountEntry ],
    *    'feb': [ AmountEntry, AmountEntry ]
    * }
    *
    */
   public function format($itemStore, $timePeriods) {
      // Build: [ 'jan', 'feb' ]
      $ids = TimePeriod::fetch_field('id', $timePeriods);

      // Build: { 'jan': 'jan', 'feb': 'feb' }
      $keyedIDs = array_combine($ids, $ids);

      // Build: { 'jan': '[ AmountEntry ], 'feb': [ AmountEntry, AmountEntry ], 'mar': [], ... }
      $output = array_map(function($id) use ($timePeriods, $itemStore){
         $period = TimePeriod::findTimePeriodWithID($timePeriods, $id);

         return array_values($itemStore->itemsForTimePeriod($period));
      }, $keyedIDs);

      if ($this->filterEmptyItems) {
         // Trim To: { 'jan': '[ AmountEntry ], 'feb': [ AmountEntry, AmountEntry ] }
         $output = array_filter($output, function($item) {
            return $item && is_array($item) && count($item) > 0;
         });
      }

      return $output;
   }
}
