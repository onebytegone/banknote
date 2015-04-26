<?php

/**
 * @copyright 2015 Ethan Smith
 */

class OutputTableGenerator extends InterfaceGenerator {

   public $showRowLabel = false;
   public $statFieldType = null;

   public function generate($package) {
      $rows = $package[$this->fieldName];
      if (!is_array($rows)) {
         $rows = array($rows);
      }

      $formatter = new ItemStoreGeneralFormatter();
      if ($this->statFieldType) {
         $formatter->statFieldCombiner = new $this->statFieldType();
      }

      $data = $formatter->formatByTimePeriod(
         $rows,
         TimePeriod::all_time_periods(),
         new PrimitiveFieldFormatter('amount'),  // How to render the field
         new EntrySumCombiner()  // How to distill the entries to a single field
      );

      $tableGenerator = new TableGenerator();
      return $this->assemble(
         "output-table",
         $this->buildContent(
            $tableGenerator->buildTable($data, $this->showRowLabel, null)
         )
      );
   }

   protected function loadSpecialized($config) {
      $this->showRowLabel = $this->field($config, 'rowLabel', false);
      $this->statFieldType = $this->field($config, 'statField', null);
   }
}
