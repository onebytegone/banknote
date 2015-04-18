<?php

/**
 * @copyright 2015 Ethan Smith
 */

class InputTableGenerator extends InterfaceGenerator {

   public function generate($package) {
      $rows = $package[$this->fieldName];
      if (!is_array($rows)) {
         $rows = array($rows);
      }

      $formatter = new ItemStoreGeneralFormatter();
      $data = $formatter->formatByTimePeriod(
         $rows,
         TimePeriod::all_time_periods(),
         new PrimitiveFieldFormatter('amount'),  // How to render the field
         new EntrySumCombiner()  // How to distill the entries to a single field
      );

      $tableGenerator = new TableGenerator();
      return $this->assemble(
         $tableGenerator->buildTable($data, true, new TableValueInputCreator())
      );
   }
}
