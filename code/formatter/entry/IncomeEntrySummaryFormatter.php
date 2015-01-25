<?php

/**
 *
 *
 * @copyright 2015 Ethan Smith
 */

class IncomeEntrySummaryFormatter {

   public function formatListOfObjects($objects) {
      return $this->formatObject(array_shift($objects));
   }

   public function formatObject($object) {
      return array(
         $object->date,
         $object->source,
         $object->amount,
         );
   }
}
