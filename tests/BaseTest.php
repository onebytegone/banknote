<?php

/**
 * @copyright 2015 Ethan Smith
 */
class BaseTest extends PHPUnit_Framework_TestCase {

   public function testFiller() { } // This is used to hide the warning

   protected function makeStore() {
      $store = new TemporalItemStore(func_get_args());
      return $store;
   }

   protected function makeAmountEntry($value, $timePeriodIndex) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }

}

