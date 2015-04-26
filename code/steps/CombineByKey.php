<?php

/**
 * Combines all the items in all the TemporalItemStores
 * into a sigle TemporalItemStore
 *
 * @copyright 2015 Ethan Smith
 */

class CombineByKey extends CalculationStep {
   public $additional = null;  // string

   protected function requiredFields() {
      return array($this->source, $this->additional);
   }

   /**
    * This is the function for subclasses to override
    * instead of calculate().
    *
    * Any needed calculations can be done in here.
    *
    * @param $package array - data package to process
    * @return array - modified package
    */
   protected function calculationTask($package) {
      $a = $package[$this->source];
      $b = $package[$this->additional];

      // Handle all items in $a
      $result = array_combine(array_keys($a), array_map(function ($key, $item) use ($b) {
         if (isset($b[$key])) {
            $item->storeItems($b[$key]->allItems());
         }

         return $item;
      }, array_keys($a), $a));

      // Get items in $b only
      $neededKeys = array_diff(array_keys($b), array_keys($result));
      $result = array_merge($result, array_intersect_key($b, array_flip($neededKeys)));

      $package[$this->output] = $result;

      return $package;
   }
}
