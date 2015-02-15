<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TemporalItemStoreTest extends PHPUnit_Framework_TestCase {

   public function testLifecycle() {
      $timePeriods = TimePeriod::all_time_periods();
      $itemA = new TemporalItem();
      $itemA->timePeriod = $timePeriods[1];
      $itemB = new TemporalItem();
      $itemB->timePeriod = $timePeriods[2];
      $items = array($itemA, $itemB);
         
      $store = new TemporalItemStore(array($itemA));
      $store->storeItem($itemB);
      
      $this->assertEquals($items, $store->allItems());
   }
   
   public function testFindByID() {
      $timePeriods = TimePeriod::all_time_periods();
      $itemA = new TemporalItem();
      $itemA->timePeriod = $timePeriods[1];
      $itemA->id = "first";
      $itemB = new TemporalItem();
      $itemB->timePeriod = $timePeriods[2];
      $itemB->id = "second";
         
      $store = new TemporalItemStore(array($itemA, $itemB));
      
      $this->assertEquals($itemA, $store->itemWithID("first"));
      $this->assertNull($store->itemWithID("unknown"));
      
   }
}

