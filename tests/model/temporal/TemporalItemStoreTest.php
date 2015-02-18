<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TemporalItemStoreTest extends PHPUnit_Framework_TestCase {

   public function testLifecycle() {
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);
      $items = array($itemA, $itemB);

      $store = new TemporalItemStore(array($itemA));
      $store->storeItem($itemB);

      $this->assertEquals($items, $store->allItems());
   }

   public function testFindByID() {
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);

      $store = new TemporalItemStore(array($itemA, $itemB));

      $this->assertEquals($itemA, $store->itemWithID("first"));
      $this->assertNull($store->itemWithID("unknown"));
   }

   public function testAllItemsByTimePeriod() {
      $itemA = $this->makeTemporalItem("first", 2);
      $itemB = $this->makeTemporalItem("second", 2);
      $itemC = $this->makeTemporalItem("third", 2);
      $itemD = $this->makeTemporalItem("fourth", 1);

      $store = new TemporalItemStore(array($itemA, $itemB));
      $store2 = new TemporalItemStore(array($itemC, $itemD));

      $this->assertEquals(
         array($itemA, $itemB, $itemC),
         TemporalItemStore::all_items_by_time_period(
            array($store, $store2),
            TimePeriod::all_time_periods()[2]
         )
      );

      $this->assertEquals(
         array($itemD),
         TemporalItemStore::all_items_by_time_period(
            array($store, $store2),
            TimePeriod::all_time_periods()[1]
         )
      );

      $this->assertEquals(
         array($itemA, $itemB),
         TemporalItemStore::all_items_by_time_period(
            array($store),
            TimePeriod::all_time_periods()[2]
         )
      );
   }

   private function makeTemporalItem($id, $timePeriodIndex) {
      $item = new TemporalItem();
      $item->id = $id;
      $item->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $item;
   }
}

