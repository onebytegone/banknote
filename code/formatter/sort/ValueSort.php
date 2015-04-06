<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ValueSort extends BaseSort {
   public function compare($a, $b) {
      if ($a[$this->sortField] < $b[$this->sortField]){
         return -1;
      }

      if ($a[$this->sortField] > $b[$this->sortField]){
         return 1;
      }

      return 0;
   }
}
