<?php

/**
 * Generates AmountEntry item from array data.
 *
 * @copyright 2015 Ethan Smith
 */

class AmountEntryFactory extends EntryFactory{
   public function buildEntry($data) {
      $entry = $this->assembleEntry(
         'AmountEntry',
         array(
            'id' => 'id',
            'amount' => 'amount',
            ),
         $data
         );
      $entry->timePeriod = TimePeriod::fetchTimePeriodByMonthAndDay($entry->date);

      return $entry;
   }
}
