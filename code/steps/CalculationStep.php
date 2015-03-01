<?php

/**
 * Handles a specific calculation step. This is the template to
 * base the specialized steps off. By itself this only copies the
 * source field to the destination.
 *
 * @copyright 2015 Ethan Smith
 */

class CalculationStep {
   public $sourceField = null;  // string
   public $outputField = null;  // string

   /**
    * Handles the calculation for the step. Takes the
    * contents from the $this->sourceField and puts them
    * in the $this->outputField of the package.
    *
    * NOTE: This function should not be overridden by
    *       subclasses. Override calculationTask instead.
    *
    * @param $package array - data package to process
    * @return array - modified package
    */
   public function calculate($package) {
      return $this->calculationTask($package);
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
   private function calculationTask($package) {
      return self::duplicate_field($package[$this->outputField], $this->sourceField, $this->outputField);
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