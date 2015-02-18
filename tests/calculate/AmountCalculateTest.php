<?php

/**
 * @copyright 2015 Ethan Smith
 */
class AmountCalculateTest extends PHPUnit_Framework_TestCase {

   public function testSumEntriesByTimePeriod() {
      $sourceA = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(7, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4),
      ));

      $sourceB = new TemporalItemStore(array(
         $this->makeAmountEntry(2, 1),
         $this->makeAmountEntry(5, 1),
         $this->makeAmountEntry(1, 3),
         $this->makeAmountEntry(1, 4),
         $this->makeAmountEntry(4, 7),
      ));

      $targetSingle = new TemporalItemStore(array(
         $this->makeAmountEntry(11, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4)
      ));

      $targetMultiple = new TemporalItemStore(array(
         $this->makeAmountEntry(18, 1),
         $this->makeAmountEntry(3, 3),
         $this->makeAmountEntry(10, 4),
         $this->makeAmountEntry(4, 7)
      ));

      $calculate = new AmountCalculate();

      $this->assertEquals($targetSingle, $calculate->sumEntriesByTimePeriod($sourceA, TimePeriod::all_time_periods()));
      $this->assertEquals($targetMultiple, $calculate->sumEntriesByTimePeriod(array($sourceA, $sourceB), TimePeriod::all_time_periods()));
   }

   public function testTotalAmountForEntries() {
      $entries = array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(7, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4),
      );

      $calculate = new AmountCalculate();
      $this->assertEquals(0, $calculate->totalAmountForEntries(array()));
      $this->assertEquals(2.42, $calculate->totalAmountForEntries(array($this->makeAmountEntry(2.42, 0))));
      $this->assertEquals(22, $calculate->totalAmountForEntries($entries));
   }

   private function makeAmountEntry($value, $timePeriodIndex) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }
}

