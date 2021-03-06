<?php

/**
 * @copyright 2015 Ethan Smith
 */

class InterfaceGenerator {
   public $fieldName = '';
   public $name = null;

   public function extraStyleClass() {

   }

   public function generate($package, $extraClasses = "") {
      return "Error: `generate` is not handled for ".get_class($this);
   }

   public function buildHeader($headerTitle) {
      if ($headerTitle) {
         return "<h1>{$headerTitle}</h1>";
      }

      return null;
   }

   public function assemble($class, $contentItems) {
      $parts = array(
         '<div class="interface ' . $class . '">'
      );
      $parts = array_merge($parts, $contentItems);
      $parts[] = '</div>';

      return join($parts, "\n");
   }

   public function buildContent() {
      $parts = array(
         $this->buildHeader($this->name),
      );
      $parts = array_merge($parts, array_filter(func_get_args()));

      return $parts;
   }

   protected function field($obj, $name, $default) {
      return isset($obj[$name]) ? $obj[$name] : $default;
   }

   public function loadFromConfig($config) {
      $this->fieldName = $config['object'];
      $this->name = $config['name'];
      $this->loadSpecialized($config);
   }

   protected function loadSpecialized($config) { }


}
