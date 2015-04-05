<?php

/**
 * Handles a specific calculation step. This is the template to
 * base the specialized steps off. By itself this only copies the
 * source field to the destination.
 *
 * @copyright 2015 Ethan Smith
 */

class CalculationStep {
   public $source = null;  // string
   public $output = null;  // string

   /**
    * Handles the calculation for the step. Takes the
    * contents from the $this->source and puts them
    * in the $this->output of the package.
    *
    * NOTE: This function should not be overridden by
    *       subclasses. Override calculationTask instead.
    *
    * @param $package array - data package to process
    * @return array - modified package
    */
   public function calculate($package) {
      if (!$this->packageHasNeededFields($package)) {
         throw new Exception("Package does not have needed fields [".join($this->requiredFields(), ', ')."]", 1);
      }

      return $this->calculationTask($package);
   }

   public function packageHasNeededFields($package) {
      return count(array_diff($this->requiredFields(), array_keys($package))) == 0;
   }

   protected function requiredFields() {
      return array($this->source);
   }

   /**
    * This is the function for subclasses to override
    * instead of calculate().
    *
    * Any needed calculations can be done in here.
    *
    * @param $package array - data package to process
    * @return array - modified package
    */
   protected function calculationTask($package) {
      return self::duplicate_field($package[$this->output], $this->source, $this->output);
   }


   /**
    * Duplicates the contents of the specified field
    * into the target field.
    *
    * NOTE: This will not duplicate an object. Only
    *       create a new reference to it. See the
    *       unit tests for an example of this.
    *
    * @param $package array - data package to process
    * @param $fieldName string - name of source field
    * @param $targetFieldName string - name of target field
    * @return array - modified package
    */
   static public function duplicate_field($package, $fieldName, $targetFieldName) {
      $package[$targetFieldName] = $package[$fieldName];

      return $package;
   }
}
