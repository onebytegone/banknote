<?php

/**
 * Sums all the values of the set
 * Example: (This assumes that all entries have the same TimePeriod)
 * $input = [
 *    "cat": [ store([ entry(5), entry(5) ]), store([ entry(5) ]) ],
 *    "dog": [ store([ entry(6), entry(2) ]) ]
 * ]
 *
 * $output = [
 *    "cat": store([ entry(15) ]),
 *    "dog": store([ entry(8) ])
 * ]
 *
 * @copyright 2015 Ethan Smith
 */

class TotalByKey extends CalculationStep {

   private $amountCalculate;

   public function __construct() {
      $this->amountCalculate = new AmountCalculate();
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
      $input = $package[$this->source];

      $result = array_map(function ($item) {
         return $this->amountCalculate->sumEntriesByTimePeriod($item, TimePeriod::all_time_periods());
      }, $input);

      $package[$this->output] = $result;

      return $package;
   }
}
