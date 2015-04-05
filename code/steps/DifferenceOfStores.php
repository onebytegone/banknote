<?php

/**
 * Handles calculating the difference of two TemporalStores
 * of AmountEntries by the respective time periods.
 *
 * @copyright 2015 Ethan Smith
 */

class DifferenceOfStores extends CalculationStep {
   public $subtrahend = null;  // string

   private $amountCalculate;

   public function __construct() {
      $this->amountCalculate = new AmountCalculate();
   }

   protected function requiredFields() {
      return array($this->source, $this->subtrahend);
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
      $subtrahendValue = $package[$this->subtrahend];

      if (is_array($input) && is_array($subtrahendValue)) {
         $keys = array_keys($input);
         $difference = array_combine($keys, array_map(function ($item, $key) use ($subtrahendValue) {
            return $this->amountCalculate->differenceOfEntriesByTimePeriod($item, $subtrahendValue[$key], TimePeriod::all_time_periods());
         }, $input, $keys));
         $package[$this->output] = $difference;
      } else {
         $total = $this->amountCalculate->differenceOfEntriesByTimePeriod($input, $subtrahendValue, TimePeriod::all_time_periods());
         $package[$this->output] = $total;
      }

      return $package;
   }
}
