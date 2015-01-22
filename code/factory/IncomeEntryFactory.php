<?php

/**
 * Generates IncomeEntry item from array data.
 *
 * @copyright 2015 Ethan Smith
 */

class IncomeEntryFactory extends EntryFactory{
   public function buildEntry($data) {
      $entry = $this->assembleEntry(
         'IncomeEntry',
         array(
            'id' => 'id',
            'amount' => 'amount',
            'date' => 'date',
            'notes' => 'notes',
            'source' => 'source',
            ),
         $data
         );
      $entry->timePeriod = TimePeriod::fetchTimePeriodByMonthAndDay($entry->date);

      return $entry;
   }
}
