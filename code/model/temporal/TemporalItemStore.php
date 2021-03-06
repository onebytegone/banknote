<?php

/**
 * Stores a set of TemporalItems. Allows lookup by TimePeriod.
 *
 * @copyright 2015 Ethan Smith
 */

class TemporalItemStore implements PackageIO {
   private $items = array();

   function __construct($items = array()) {
      $this->items = $items;
   }

   /**
    * Returns all the stored objects sorted by time period.
    *
    * @return array - list of items stored
    */
   public function allItems() {
      TemporalItemStore::sort_items_by_time_period($this->items);
      return $this->items;
   }

   /**
    * Stores the items in the array.
    *
    * @param $newItems array - array of items to store
    */
   public function storeItems($newItems) {
      $this->items = array_merge($this->items, $newItems);
   }

   /**
    * Stores the given item.
    *
    * @param $item object - item to store
    */
   public function storeItem($item) {
      $this->items[] = $item;
   }

   public function anyItemForTimePeriod($timePeriod) {
      $itemsForPeriod = $this->itemsForTimePeriod($timePeriod);
      return array_shift($itemsForPeriod);
   }

   public function itemsForTimePeriod($timePeriod) {
      return array_filter($this->items, function ($item) use ($timePeriod) {
         return TimePeriod::areEquivalent($item->timePeriod, $timePeriod);
      });
   }

   public function itemWithID($id) {
      $foundItems = array_filter($this->items, function ($item) use ($id) {
         return $item->id == $id;
      });

      return array_shift($foundItems);
   }

   public function generateValueSummary($formatter, $timePeriods) {
      $self = $this;
      $summary = array_reduce($timePeriods, function($carry, $timePeriod) use ($self, $formatter) {
         $entries = $self->itemsForTimePeriod($timePeriod);

         if ($entries && count($entries) > 0) {
            $carry[] = $formatter->formatListOfObjects($entries);
         }

         return $carry;
      }, array());
      return $summary;
   }

   static public function sort_items_by_time_period(&$items) {
      usort($items, function($a, $b) {
         return $a->timePeriod->compareTo($b->timePeriod);
      });
   }

   /**
    * Creates an array of all the items in the TemporalItemStores
    * for a given TimePeriod
    *
    * @param $stores array - Array of TemporalItemStores
    * @param $timePeriod TimePeriod
    * @return array
    */
   static public function all_items_by_time_period($stores, $timePeriod) {
      // Make sure we always use an array
      if (!is_array($stores)) {
         $stores = array($stores);
      }

      return array_reduce($stores, function ($carry, $store) use ($timePeriod) {
         return array_merge($carry, $store->itemsForTimePeriod($timePeriod));
      }, array());
   }

   /**
    * Compares two sets of TemporalItemStores.
    *
    * @param $storesA array - Array of TemporalItemStores
    * @param $storesB array - Array of TemporalItemStores
    * @return array
    */
   static public function compare_stores($storesA, $storesB) {
      // Make sure we always use an array
      if (!is_array($storesA)) {
         $storesA = array($storesA);
      }
      if (!is_array($storesB)) {
         $storesB = array($storesB);
      }

      $diff = array_udiff($storesA, $storesB, array('self', 'compare_single_stores'));
      return count($diff) == 0;
   }

   /**
    * Compares two of TemporalItemStores.
    *
    * @param $storeA array - TemporalItemStore
    * @param $storeB array - TemporalItemStore
    * @return array
    */
   static public function compare_single_stores($storeA, $storeB) {
      $diff = array_udiff($storeA->allItems(), $storeB->allItems(), function($a, $b) {
         return AmountEntry::compare($a, $b) ? 0 : 1;
      });

      return count($diff);
   }


   /**
    * Part of interface for PackageIO
    */
   public function exportToPackage() {
      return array_map(function ($item) {
         return $item->exportFields();
      }, $this->allItems());
   }


   /**
    * Part of interface for PackageIO
    */
   static public function buildFromPackage($data) {

   }
}
