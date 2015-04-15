<?php

/**
 * @copyright 2015 Ethan Smith
 */

class TableValueSanitizer {
   public function processValue($value) {
      return htmlspecialchars($value);
   }
}
