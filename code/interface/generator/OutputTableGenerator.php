<?php

/**
 * @copyright 2015 Ethan Smith
 */

class OutputTableGenerator extends InterfaceGenerator {
   public function generate($package) {
      $rows = $package[$this->fieldName];
      if (!is_array($rows)) {
         $rows = array($rows);
      }

      $fieldFormatter = new EntryFieldFormatter('amount');
      $entryCombiner = new EntrySumCombiner();
      $formatter = new ItemStoreGeneralFormatter();
      $tableGenerator = new TableGenerator();
      $data = $formatter->formatByTimePeriod($rows, TimePeriod::all_time_periods(), $fieldFormatter, $entryCombiner);

      return $this->assemble(
         $tableGenerator->buildTable($data, true)
      );
   }
}
