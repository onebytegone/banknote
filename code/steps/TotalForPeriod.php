<?php

/**
 * Handles the totaling of a TemporalStore of AmountEntries
 * by the respective time periods.
 *
 * @copyright 2015 Ethan Smith
 */

class TotalForPeriod extends CalculationStep {
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
      $total = $this->amountCalculate->sumEntriesByTimePeriod($input, TimePeriod::all_time_periods());
      $package[$this->outputField] = $total;

      return $package;
   }
}
