<?php

/**
 * Generates HTML table
 *
 * @copyright 2015 Ethan Smith
 */

class TableGenerator {

   /**
    * input:
    * array(
    *   'header' => TimePeriod::fetch_names(),
    *   'items' => array(
    *      'store a' => array(
    *         'jan' => '4',
    *         'mar' => '2',
    *         'may' => '9',
    *      ),
    *      'store b' => array(
    *         'feb' => '6',
    *         'july' => '9',
    *      ),
    *   )
    * );
    */

   public function buildTable($data, $showsRowLabel, $sanitize = true) {
      $table = new TableElement();
      $table->sanitize = $sanitize;

      $header = $data['header'];
      if ($header && count($header) > 0) {
         $this->addLabelToItems($header, $showsRowLabel);
         $table->addRow($header);
      }

      $self = $this;
      $items = $data['items'];
      $table = array_reduce(array_keys($items), function ($table, $name) use ($self, $items, $showsRowLabel) {
         $rowData = $items[$name];
         $self->addLabelToItems($rowData, $showsRowLabel, $name);
         $table->addRow($rowData);
         return $table;
      }, $table);

      return $table->exportTableAsHTML();
   }


   /**
    * Appends a label to the item array if we should force having label or
    * there is a label defined. We won't add a label in the case of no label
    * data and the label is not forced.
    *
    * @param &$items array - array with the items. may be added to.
    * @param $showsLabel boolean - should a label be shown
    * @param $name string - string for the label
    */
   public function addLabelToItems(&$items, $showsLabel, $name = null) {
      $label = $showsLabel ? $name : null;
      $label = $showsLabel && !$label ? '' : $label;

      if ($label || is_string($label)) {
         array_unshift($items, $label);
      }
   }
}
