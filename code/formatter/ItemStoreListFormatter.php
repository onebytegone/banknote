<?php

/**
 * Generates a set of list data for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreListFormatter {
   public function format($itemStore, $timePeriods, $fieldFormatters) {
      $output = array();

      $output['header'] = array_map(function($formatter) {
         return $formatter->readableName;
      }, $fieldFormatters);

      $output['items'] = array_reduce($timePeriods, function($list, $period) use ($itemStore, $fieldFormatters) {
         $items = $itemStore->itemsForTimePeriod($period);

         $list = array_merge($list, array_map(function ($entry) use ($fieldFormatters) {
            return array_map(function($formatter) use ($entry) {
               return $formatter->format($entry);
            }, $fieldFormatters);
         }, $items));

         return $list;
      }, array());

      return $output;
   }
}
