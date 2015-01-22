<?php

/**
 * Generates IncomeEntry item from array data.
 *
 * @copyright 2015 Ethan Smith
 */

class IncomeEntryFactory {
   public function buildEntry($data) {
      $entry = new IncomeEntry();
      $entry->id = $data['id'];
      $entry->amount = $data['amount'];
      $entry->date = $data['date'];
      $entry->notes = $data['notes'];
      $entry->source = $data['source'];
      $entry->timePeriod = TimePeriod::fetchTimePeriodByMonthAndDay($entry->date);

      return $entry;
   }
}
