<?php

/**
 * @copyright 2015 Ethan Smith
 */
class EntrySumCombinerTest extends PHPUnit_Framework_TestCase {

   public function testCombine() {
      $entriesA = array(
         $this->makeAmountEntry(4, 5),
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(4, 2),
         $this->makeAmountEntry(4, 3)
      );

      $entriesB = array(
         $this->makeAmountEntry(1, 0),
         $this->makeAmountEntry(3, 1),
         $this->makeAmountEntry(-2, 2)
      );

      $combiner = new EntrySumCombiner();

      $this->assertEquals($this->makeAmountEntry(16, 5), $combiner->combine($entriesA));
      $this->assertEquals($this->makeAmountEntry(2, 0), $combiner->combine($entriesB));
      $this->assertNull($combiner->combine(array()));
      $this->assertNull($combiner->combine(null));
   }

   private function makeAmountEntry($value, $timePeriodIndex) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }
}

