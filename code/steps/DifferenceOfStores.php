<?php

/**
 * Handles calculating the differnece of two TemporalStores
 * of AmountEntries by the respective time periods.
 *
 * @copyright 2015 Ethan Smith
 */

class DifferenceOfStores extends CalculationStep {
   public $subtrahendField = null;  // string

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
   private function calculationTask($package) {
      $input = $package[$this->sourceField];
      $subtrahend = $package[$this->subtrahendField];

      $total = $this->amountCalculate->differenceOfEntriesByTimePeriod($input, $subtrahend, TimePeriod::all_time_periods());

      $package[$this->outputField] = $total;

      return $package;
   }
}
