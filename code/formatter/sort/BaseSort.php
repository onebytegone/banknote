<?php

/**
 * @copyright 2015 Ethan Smith
 */

class BaseSort {
   public $sortField = '';

   public function sort(&$items) {
      usort($items, array($this, 'compare'));
   }

   public function compare($a, $b) {
      return 0;
   }
}
