<?php

/**
 * @copyright 2015 Ethan Smith
 */

class DateSort extends BaseSort {
   public function compare($a, $b) {
      if (strtotime($a[$this->sortField]) < strtotime($b[$this->sortField])){
         return -1;
      }

      if (strtotime($a[$this->sortField]) > strtotime($b[$this->sortField])){
         return 1;
      }

      return 0;
   }
}
