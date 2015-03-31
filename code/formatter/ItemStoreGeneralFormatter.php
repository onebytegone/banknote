<?php

/**
 * Generates basic array data for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreGeneralFormatter {
   public function formatByTimePeriod($itemStores, $timePeriods, $fieldFormatter, $fieldCombiner) {
      $output = array();

      $output['header'] = TimePeriod::fetch_names($timePeriods);

      $storeArrayMap = new ItemStoreArrayMap();
      $output['items'] = array_map(function ($store) use ($storeArrayMap, $timePeriods, $fieldFormatter, $fieldCombiner) {
         $storeEntries = $storeArrayMap->format($store, $timePeriods);

         $items = array_map(function ($entryList) use ($fieldCombiner, $fieldFormatter) {
            $entry = $fieldCombiner->combine($entryList);
            return $fieldFormatter->format($entry);
         }, $storeEntries);

         return $items;
      }, $itemStores);

      return $output;
   }
}
