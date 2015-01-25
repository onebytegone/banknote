<?php

/**
 * Generates HTML table for TemporalItemStores
 *
 * @copyright 2015 Ethan Smith
 */

class ItemStoreTableFormatter {

   public function buildListTableOfEntries($items, $fieldFormatter, $header = null) {
      $table = new TableElement();

      if ($header) {
         $table->addRow($header);
      }

      array_walk($items, function ($item) use ($table, $fieldFormatter) {
         $table->addRow($fieldFormatter->formatObject($item));
      });

      return $table->exportTableAsHTML();
   }


   public function buildTableByTimePeriod($itemStores, $timePeriods, $fieldFormatter, $header = null, $showsRowLabel = true) {
      $table = new TableElement();

      if ($header) {
         $table->addRow($header);
      }

      $self = $this;
      array_walk(array_keys($itemStores), function ($name) use ($self, $table, $fieldFormatter, $timePeriods, $itemStores, $showsRowLabel) {
         $items = $itemStores[$name]->generateValueSummary($fieldFormatter, $timePeriods);

         $self->addLabelToItems($items, $showsRowLabel, $name);
         $table->addRow($items);
      });

      return $table->exportTableAsHTML();
   }


   public function addLabelToItems(&$items, $showsLabel, $label = null) {
      $label = $showsLabel ? $name : null;
      $label = $showsLabel && !$label ? '' : $label;

      if ($label || is_string($label)) {
         array_unshift($items, $label);
      }
   }
}
