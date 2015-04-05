<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ListGenerator extends InterfaceGenerator {
   public function generate($package) {
      $rows = $package[$this->fieldName];

      $formatter = new ItemStoreListFormatter();
      $data = $formatter->format(
         $rows,
         TimePeriod::all_time_periods(),
         array(
            new PrimitiveFieldFormatter('date', '%s', 'Date'),
            new PrimitiveFieldFormatter('name', '%s', 'Item'),
            new PrimitiveFieldFormatter('amount', '$%f', 'Amount')
         )
      );

      $tableGenerator = new TableGenerator();
      return $this->assemble(
         $tableGenerator->buildTable($data, false)
      );
   }
}
