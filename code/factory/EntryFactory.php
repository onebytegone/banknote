<?php

/**
 * Generates an entry item
 *
 * @copyright 2015 Ethan Smith
 */

class EntryFactory {
   public function assembleEntry($type, $map, $data) {
      return array_reduce(array_keys($map), function($item, $key) use ($data, $map, $entry) {
         $targetField = $map[$key];
         $item->$targetField = $data[$key];
         return $item;
      }, new $type());
   }
}
