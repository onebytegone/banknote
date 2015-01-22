<?php

/**
 * Generates ExpenseEntry item from array data.
 *
 * @copyright 2015 Ethan Smith
 */

class ExpenseEntryFactory extends EntryFactory{
   public function buildEntry($data) {
      $entry = $this->assembleEntry(
         'IncomeEntry',
         array(
            'id' => 'id',
            'name' => 'name',
            'fundID' => 'fund',
            'amount' => 'amount',
            'date' => 'date',
            'notes' => 'notes',
            ),
         $data
         );
      $entry->timePeriod = TimePeriod::fetchTimePeriodByMonthAndDay($entry->date);

      return $entry;
   }
}
