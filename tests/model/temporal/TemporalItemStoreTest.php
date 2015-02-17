<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TemporalItemStoreTest extends PHPUnit_Framework_TestCase {

   public function testLifecycle() {
      $timePeriods = TimePeriod::all_time_periods();
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);
      $items = array($itemA, $itemB);

      $store = new TemporalItemStore(array($itemA));
      $store->storeItem($itemB);

      $this->assertEquals($items, $store->allItems());
   }

   public function testFindByID() {
      $timePeriods = TimePeriod::all_time_periods();
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);

      $store = new TemporalItemStore(array($itemA, $itemB));

      $this->assertEquals($itemA, $store->itemWithID("first"));
      $this->assertNull($store->itemWithID("unknown"));
   }

   private function makeTemporalItem($id, $timePeriodIndex) {
      $item = new TemporalItem();
      $item->id = $id;
      $item->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $item;
   }
}

