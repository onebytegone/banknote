<?php

/**
 * @copyright 2015 Ethan Smith
 */
class AmountCalculateTest extends PHPUnit_Framework_TestCase {

   public function testDifferenceOfEntriesByTimePeriod() {
      $sourceA = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 5),
      ));

      $sourceB = new TemporalItemStore(array(
         $this->makeAmountEntry(2, 1),
         $this->makeAmountEntry(0.5, 3),
         $this->makeAmountEntry(4, 7),
      ));

      $target = new TemporalItemStore(array(
         $this->makeAmountEntry(2, 1),
         $this->makeAmountEntry(1.5, 3),
         $this->makeAmountEntry(9, 5),
         $this->makeAmountEntry(-4, 7)
      ));

      $calculate = new AmountCalculate();

      $this->assertEquals($target, $calculate->differenceOfEntriesByTimePeriod($sourceA, $sourceB, TimePeriod::all_time_periods()));
   }

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

   public function testCalculateRunningTotal() {
      $sourceA = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(7, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 4),
      ));

      $sourceB = new TemporalItemStore(array(
         $this->makeAmountEntry(100, 0),
         $this->makeAmountEntry(2, 1),
         $this->makeAmountEntry(5, 1),
         $this->makeAmountEntry(1, 3),
         $this->makeAmountEntry(1, 4),
         $this->makeAmountEntry(4, 7),
      ));

      $targetSingle = new TemporalItemStore(array(
         $this->makeAmountEntry(0, 0),
         $this->makeAmountEntry(11, 1),
         $this->makeAmountEntry(11, 2),
         $this->makeAmountEntry(13, 3),
         $this->makeAmountEntry(22, 4),
         $this->makeAmountEntry(22, 5),
         $this->makeAmountEntry(22, 6),
         $this->makeAmountEntry(22, 7),
         $this->makeAmountEntry(22, 8),
         $this->makeAmountEntry(22, 9),
         $this->makeAmountEntry(22, 10),
         $this->makeAmountEntry(22, 11),
         $this->makeAmountEntry(22, 12)
      ));

      $targetMultiple = new TemporalItemStore(array(
         $this->makeAmountEntry(100, 0),
         $this->makeAmountEntry(118, 1),
         $this->makeAmountEntry(118, 2),
         $this->makeAmountEntry(121, 3),
         $this->makeAmountEntry(131, 4),
         $this->makeAmountEntry(131, 5),
         $this->makeAmountEntry(131, 6),
         $this->makeAmountEntry(135, 7),
         $this->makeAmountEntry(135, 8),
         $this->makeAmountEntry(135, 9),
         $this->makeAmountEntry(135, 10),
         $this->makeAmountEntry(135, 11),
         $this->makeAmountEntry(135, 12)
      ));

      $calculate = new AmountCalculate();

      $this->assertEquals($targetSingle, $calculate->calculateRunningTotal($sourceA, TimePeriod::all_time_periods()));
      $this->assertEquals($targetMultiple, $calculate->calculateRunningTotal(array($sourceA, $sourceB), TimePeriod::all_time_periods()));
   }


   public function testSumEntriesByCategory() {
      $entries = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1, 'dog'),
         $this->makeAmountEntry(7, 1, 'cow'),
         $this->makeAmountEntry(2, 3, 'dog'),
         $this->makeAmountEntry(2, 3, 'dog'),
      ));

      $target = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1, 'dog'),
         $this->makeAmountEntry(7, 1, 'cow'),
         $this->makeAmountEntry(4, 3, 'dog'),
      ));

      $calculate = new AmountCalculate();

      $this->assertEquals($target, $calculate->sumEntriesByCategory($entries, 'source', TimePeriod::all_time_periods()));
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

   public function testTotalByCategoriesForEntries() {
      $entries = array(
         $this->makeAmountEntry(4, 1, 'dog'),
         $this->makeAmountEntry(7, 1, 'cow'),
         $this->makeAmountEntry(2, 3, 'fish'),
         $this->makeAmountEntry(2, 3, 'dog'),
      );

      $target = array(
         'dog' => 6,
         'cow' => 7,
         'fish' => 2
      );

      $calculate = new AmountCalculate();

      $this->assertEquals($target, $calculate->totalByCategoriesForEntries($entries, 'source'));
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

