<?php

/**
 * Stores HTML table data
 *
 * @copyright 2015 Ethan Smith
 */

class TableElement {

   public $attributes = array();

   private $tableData = '';


   public function addRow($values) {
      $rowContents = array_reduce($values, function ($carry, $item) {
         $value = htmlspecialchars($item);
         return $carry."<td>{$value}</td>";
      }, '');

      $this->tableData .= "<tr>{$rowContents}</tr>";
   }


   public function exportTableAsHTML() {
      $attrList = $this->attributes;
      $attrOuput = array_reduce(array_keys($attrList), function ($carry, $item) use ($attrList) {
         $name = htmlspecialchars($item);
         $value  = htmlspecialchars($attrList[$item]);
         return $carry." {$name}=\"{$value}\"";
      }, '');
      return "<table {$attrOuput}>{$this->tableData}</table>";
   }
}
