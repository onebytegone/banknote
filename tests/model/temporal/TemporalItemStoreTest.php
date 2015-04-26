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

      $storeAll = new TemporalItemStore();
      $storeAll->storeItems($items);

      $this->assertEquals($items, $store->allItems());
      $this->assertEquals($items, $storeAll->allItems());
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

   public function testCompareSingleStore() {
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);
      $itemC = $this->makeTemporalItem("second", 2);
      $itemD = $this->makeTemporalItem("second", 3);

      $storeA = new TemporalItemStore(array($itemA, $itemB));
      $storeB = new TemporalItemStore(array($itemA, $itemC));
      $storeC = new TemporalItemStore(array($itemA));
      $storeD = new TemporalItemStore(array($itemA, $itemD));

      //$this->assertTrue(TemporalItemStore::compare_single_stores($storeA, $storeA));
      //$this->assertTrue(TemporalItemStore::compare_single_stores($storeA, $storeB));
      //$this->assertTrue(TemporalItemStore::compare_single_stores($storeB, $storeA));
      //$this->assertFalse(TemporalItemStore::compare_single_stores($storeA, $storeC));
      //$this->assertFalse(TemporalItemStore::compare_single_stores($storeA, $storeD));
   }

   public function testCompareStores() {
      $itemA = $this->makeTemporalItem("first", 1);
      $itemB = $this->makeTemporalItem("second", 2);
      $itemC = $this->makeTemporalItem("second", 2);
      $itemD = $this->makeTemporalItem("second", 3);

      $storeA = new TemporalItemStore(array($itemA, $itemB));
      $storeB = new TemporalItemStore(array($itemA, $itemC));
      $storeC = new TemporalItemStore(array($itemA));
      $storeD = new TemporalItemStore(array($itemA, $itemD));

      $this->assertTrue(TemporalItemStore::compare_stores($storeA, $storeA));
      $this->assertTrue(TemporalItemStore::compare_stores($storeA, $storeB));
      $this->assertTrue(TemporalItemStore::compare_stores($storeB, $storeA));
      $this->assertFalse(TemporalItemStore::compare_stores($storeA, $storeC));
      $this->assertFalse(TemporalItemStore::compare_stores($storeA, $storeD));
   }

   private function makeTemporalItem($id, $timePeriodIndex) {
      $item = new TemporalItem();
      $item->id = $id;
      $item->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $item;
   }
}

