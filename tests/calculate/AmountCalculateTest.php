<?php

/**
 * @copyright 2015 Ethan Smith
 */
class AmountCalculateTest extends PHPUnit_Framework_TestCase {

   public function testSumEntriesByTimePeriod() {
      $entries = array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(7, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4),
      );
      $source = new TemporalItemStore($entries);

      $total = array(
         $this->makeAmountEntry(11, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4)
      );
      $target = new TemporalItemStore($total);

      $calculate = new AmountCalculate();

      $this->assertEquals($target, $calculate->sumEntriesByTimePeriod($source, TimePeriod::all_time_periods()));
   }

   private function makeAmountEntry($value, $timePeriodIndex) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }
}

