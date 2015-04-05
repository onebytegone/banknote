<?php

/**
 * @copyright 2015 Ethan Smith
 */

class InterfaceGenerator {
   public $fieldName = '';
   public $name = null;

   public function generate($package) {
      return "Error: `generate` is not handled for ".get_class($this);
   }

   public function buildHeader($headerTitle) {
      if ($headerTitle) {
         return "<h1>{$headerTitle}</h1>";
      }

      return null;
   }

   public function assemble() {
      $parts = array(
         '<div class="interface">',
         $this->buildHeader($this->name),
      );
      $parts = array_merge($parts, array_filter(func_get_args()));
      $parts[] = '</div>';

      return join($parts, "\n");
   }
}
