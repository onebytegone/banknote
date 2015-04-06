<?php

/**
 * Generates a yearly total for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreYearlyTotal {
   public $filterEmptyItems = false;
   public $name = "Yearly";

   public function format($itemStore, $timePeriods) {
      $amountCalculate = new AmountCalculate();
      $total = array_reduce($timePeriods, function($carry, $period) use ($itemStore, $amountCalculate) {
         $entries = $itemStore->itemsForTimePeriod($period);
         $periodSum = $amountCalculate->totalAmountForEntries($entries);
         return $carry + $periodSum;
      }, 0);

      $entry = new AmountEntry();
      $entry->amount = $total;

      return $entry;
   }
}
