<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TemporalItemStoreTest extends PHPUnit_Framework_TestCase {

   public function testLifecycle() {
      $itemA = new TemporalItem();
      $itemB = new TemporalItem();
      $items = array($itemA, $itemB);
         
      $store = new TemporalItemStore(array($itemA));
      $store->storeItem($itemB);
      
      $this->assertEquals($items, $store->allItems());
   }
}

