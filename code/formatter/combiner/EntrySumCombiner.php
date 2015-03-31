<?php

/**
 * Sums an array of AmountEntrys
 *
 * @copyright 2015 Ethan Smith
 */

class EntrySumCombiner {
   /**
    *
    * @param $entries array of AmountEntry
    * @return AmountEntry
    */
   public function combine($entries) {
      if (count($entries) == 0) {
         return null;
      }

      $output = new AmountEntry();
      $output->timePeriod = $entries[0]->timePeriod;
      $output->amount = array_reduce($entries, function ($carry, $entry) {
         return $carry + $entry->amount;
      }, 0);

      return $output;
   }
}
