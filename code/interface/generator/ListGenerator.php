<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ListGenerator extends InterfaceGenerator {
   public $entrySortType = null;
   public $entrySortField = null;


   public function generate($package) {
      $rows = $package[$this->fieldName];

      $formatter = new ItemStoreListFormatter();
      if ($this->entrySortType) {
         $sorter = new $this->entrySortType();
         $sorter->sortField = $this->entrySortField;
         $formatter->entrySort = $sorter;
      }

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
         $tableGenerator->buildTable($data, false, null, "list")
      );
   }

   protected function loadSpecialized($config) {
      $this->entrySortType = $this->field($config, 'sort', null);
      $this->entrySortField = $this->field($config, 'sortField', null);
   }
}
