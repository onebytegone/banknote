<?php

/**
 * @copyright 2015 Ethan Smith
 */
class InterfaceCreator {
   public $generators = array();

   public function loadFromConfig($configList) {
      $this->generators = array_filter(array_map(function($config) {
         $class = $config['type'];
         if (class_exists($class)) {
            $generator = new $class();
            $generator->fieldName = $config['object'];
            return $generator;
         }

         return null;
      }, $configList));
   }

   public function buildInterface($package) {
      return join("\n", array_map(function ($generator) use ($package) {
         return $generator->generate($package);
      }, $this->generators));
   }
}
