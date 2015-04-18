<?php

/**
 * @copyright 2015 Ethan Smith
 */

class TableValueInputCreator extends TableValueSanitizer {
   public function processValue($value) {
      return '<input value="'.parent::processValue($value).'">';
   }
}
