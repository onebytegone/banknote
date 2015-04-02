<?php

/**
 * @copyright 2015 Ethan Smith
 */
class ItemStoreArrayMapTest extends PHPUnit_Framework_TestCase {

   public function testFormatByTimePeriod() {

      $store = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 5),
      ));

      $target = array(
         'jan' => array(
            $this->makeAmountEntry(4, 1),
            $this->makeAmountEntry(4, 1),
         ),
         'feb' => array(),
         'mar' => array(
            $this->makeAmountEntry(2, 3)
         ),
         'april' => array(),
         'may' => array(
            $this->makeAmountEntry(9, 5)
         ),
         'june' => array(),
         'july' => array(),
         'aug' => array(),
         'sept' => array(),
         'oct' => array(),
         'nov' => array(),
         'dec' => array(),
      );

      $formatter = new ItemStoreArrayMap();
      $this->assertEquals($target, $formatter->format($store, TimePeriod::all_time_periods()));
   }

   private function makeAmountEntry($value, $timePeriodIndex, $category = null) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      if ($category) {
         $entry->source = $category;
      }
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }
}

