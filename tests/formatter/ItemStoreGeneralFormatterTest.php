<?php

/**
 * @copyright 2015 Ethan Smith
 */
class ItemStoreGeneralFormatterTest extends PHPUnit_Framework_TestCase {

   public function testFormatByTimePeriod() {

      $storeA = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 1),
         $this->makeAmountEntry(2, 3),
         $this->makeAmountEntry(9, 5),
      ));

      $storeB = new TemporalItemStore(array(
         $this->makeAmountEntry(4, 2),
         $this->makeAmountEntry(2, 2),
         $this->makeAmountEntry(9, 7),
      ));

      $source = array(
         'store a' => $storeA,
         'store b' => $storeB,
      );

      $target = array(
         'header' => TimePeriod::fetch_names(),
         'items' => array(
            'store a' => array(
               'jan' => '4',
               'mar' => '2',
               'may' => '9',
            ),
            'store b' => array(
               'feb' => '6',
               'july' => '9',
            ),
         )
      );

      $fieldFormatter = new EntryFieldFormatter('amount');
      $entryCombiner = new EntrySumCombiner();
      $formatter = new ItemStoreGeneralFormatter();

      $this->assertEquals($target, $formatter->formatByTimePeriod($source, TimePeriod::all_time_periods(), $fieldFormatter, $entryCombiner));
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

