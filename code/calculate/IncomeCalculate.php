<?php

/**
 * Calculations regarding income
 *
 * @copyright 2015 Ethan Smith
 */

class IncomeCalculate {
   public function totalOfEntries($incomeEntries) {
      return array_reduce($incomeEntries, function($carry, $item) {
         return $carry + $item->amount;
      }, 0);
   }
}
