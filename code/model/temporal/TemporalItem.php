<?php

/**
 * Stores data that is linked to a specific time period.
 *
 * @copyright 2015 Ethan Smith
 */

class TemporalItem {
    public $id = '';
    public $timePeriod = null;

    public function exportFields() {
      $fields = get_object_vars($this);
      $keys = array_keys($fields);

      return array_filter(array_combine($keys, array_map(function ($name, $value) {
         if ($name == 'timePeriod') {
            return null;
         }
         return $value;
      }, $keys, $fields)));
    }
}
