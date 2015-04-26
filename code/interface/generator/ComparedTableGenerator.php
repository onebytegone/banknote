<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ComparedTableGenerator extends OutputTableGenerator {

   public $compareName = null;

   public function generate($package, $extraClasses = "") {
      $extraClasses = TemporalItemStore::compare_stores(
         $package[$this->fieldName],
         $package[$this->compareName]
      ) ? "equal" : "not-equal";

      return parent::generate($package, 'compared ' . $extraClasses);
   }

   protected function loadSpecialized($config) {
      parent::loadSpecialized($config);
      $this->compareName = $config['compare'];
   }
}
