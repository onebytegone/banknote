<?php

/**
 * Creates a formatted value from a field on the given object.
 *
 * @copyright 2015 Ethan Smith
 */

class InputFieldFormatter extends PrimitiveFieldFormatter {
   public function formatFieldValue($value) {
      $value = '<input value="'.parent::formatFieldValue($value).'">';
      return $value;
   }
}
