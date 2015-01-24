<?php

/**
 * Generates HTML table for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreTableFormatter {

   public function buildTable($itemStore, $timePeriods, $fieldFormatter, $header = null) {
      $table = new TableElement();

      if ($header) {
         $table->addRow($header);
      }

      // TODO: allow multiple rows
      $this->addTableRowForField($table, $itemStore, $fieldFormatter, $timePeriods, "Fund");

      return $table->exportTableAsHTML();

   }

   public function addTableRowForField(&$table, $itemStore, $formatter, $timePeriods, $label = null) {
      $items = $itemStore->generateValueSummary($formatter, $timePeriods);

      if ($label) {
         array_unshift($items, $label);
      }

      $table->addRow($items);
   }
}
