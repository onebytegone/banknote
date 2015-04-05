<?php

/**
 * Creates a formatted value from a field on the given object.
 *
 * @copyright 2015 Ethan Smith
 */

class PrimitiveFieldFormatter extends FieldFormatter {

   public $format;

   function __construct($field = "value", $format = "%f", $name = "Value") {
      $this->field = $field;
      $this->format = $format;
      $this->readableName = $name;
   }

   public function formatFieldValue($value) {
      return sprintf($this->format, $value);
   }
}
