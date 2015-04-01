<?php

/**
 * @copyright 2015 Ethan Smith
 */

class OutputTableGenerator {
   public $fieldName = '';

   public function generate($package) {
      $incomeEntryStore = $package[$this->fieldName];

      $fieldFormatter = new EntryFieldFormatter('amount');
      $entryCombiner = new EntrySumCombiner();
      $formatter = new ItemStoreGeneralFormatter();
      $tableGenerator = new TableGenerator();
      $data = $formatter->formatByTimePeriod(array( 'income' => $incomeEntryStore), TimePeriod::all_time_periods(), $fieldFormatter, $entryCombiner);
      return $tableGenerator->buildTable($data, true);
   }
}
