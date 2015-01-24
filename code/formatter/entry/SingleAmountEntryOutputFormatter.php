<?php

/**
 *
 *
 * @copyright 2015 Ethan Smith
 */

class SingleAmountEntryOutputFormatter implements EntryFormatOutput {

   public $currencyFormat = "%f";
   public $returnEmptyWhenZero = false;

   function __construct($currencyFormat = "%f") {
      $this->currencyFormat = $currencyFormat;
   }

   public function formatListOfObjects($objects) {
      return $this->formatObject(array_shift($objects));
   }

   public function formatObject($object) {
      $amount = $object->amount;

      if ($this->returnEmptyWhenZero && $amount == 0) {
         return '';
      }

      return sprintf($this->currencyFormat, $amount);
   }
}
