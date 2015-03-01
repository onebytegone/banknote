<?php

/**
 * Handles the totaling of a TemporalStore of AmountEntries
 * by the respective category where the values are the same.
 *
 * @copyright 2015 Ethan Smith
 */

class TotalByCategory extends CalculationStep {
   public $category = null;  // string

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
      $total = $this->amountCalculate->sumEntriesByCategory(
         $input,
         $this->category,
         TimePeriod::all_time_periods()
      );
      $package[$this->output] = $total;

      return $package;
   }
}
