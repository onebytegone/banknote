<?php

/**
 * Creates a foramtted value from a field on the given object.
 *
 * @copyright 2015 Ethan Smith
 */

class EntryFieldFormatter {

   public $format;
   public $field;
   public $returnEmptyWhenEmpty = false;

   function __construct($field = "value", $format = "%f") {
      $this->field = $field;
      $this->format = $format;
   }

   public function format($object) {
      $value = $object->{$this->field};

      if ($this->returnEmptyWhenEmpty && !$value) {
         return '';
      }

      return sprintf($this->format, $value);
   }
}
