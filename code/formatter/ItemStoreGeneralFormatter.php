<?php

/**
 * Generates basic array data for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreGeneralFormatter {
   public function formatByTimePeriod($itemStores, $timePeriods, $fieldFormatter) {
      $output = array();

      $output['header'] = TimePeriod::fetch_names($timePeriods);

      $self = $this;
      $output['items'] = array_reduce(array_keys($itemStores), function ($output, $name) use ($self, $fieldFormatter, $timePeriods, $itemStores) {
         $items = $itemStores[$name]->generateValueSummary($fieldFormatter, $timePeriods);

         $output[$name] = $items;
         return $output;
      }, array());

      return $output;
   }
}
