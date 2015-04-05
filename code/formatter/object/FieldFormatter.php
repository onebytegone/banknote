<?php

/**
 * Base class for object formatters
 *
 * @copyright 2015 Ethan Smith
 */

class FieldFormatter {

   public $field;
   public $defaultReturn = '';
   public $returnDefaultWhenEmpty = false;
   public $readableName = null;

   function __construct($field = "value") {
      $this->field = $field;
   }

   public function format($object) {
      if (!$object) {
         return $this->defaultReturn;
      }

      $value = $object->{$this->field};

      if ($this->returnDefaultWhenEmpty && !$value) {
         return $this->defaultReturn;
      }

      return $this->formatFieldValue($value);
   }

   protected function formatFieldValue($fieldValue) {
      return $fieldValue;
   }
}
