<?php

/**
 * Creates a formatted value from a field on the given object.
 *
 * @copyright 2015 Ethan Smith
 */

class PrimitiveFieldFormatter {

   public $format;
   public $field;
   public $defaultReturn = '';
   public $returnDefaultWhenEmpty = false;
   public $readableName = null;

   function __construct($field = "value", $format = "%f") {
      $this->field = $field;
      $this->format = $format;
   }

   public function format($object) {
      if (!$object) {
         return $this->defaultReturn;
      }

      $value = $object->{$this->field};

      if ($this->returnDefaultWhenEmpty && !$value) {
         return $this->defaultReturn;
      }

      return sprintf($this->format, $value);
   }
}
