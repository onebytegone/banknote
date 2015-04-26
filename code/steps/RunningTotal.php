<?php

/**
 * Sums all the values of the set then adds this to a
 * running total which is then stored.
 *
 * @copyright 2015 Ethan Smith
 */

class RunningTotal extends CalculationStep {

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
         return $this->amountCalculate->calculateRunningTotal($item, TimePeriod::all_time_periods());
      }, $input);

      $package[$this->output] = $result;

      return $package;
   }
}
