<?php

/**
 * Generates CalculationStep item from array data.
 *
 * @copyright 2015 Ethan Smith
 */

class CalculationStepFactory {

   /**
    * Builds a set of steps from an array of config info.
    *
    * Example config;
    * [
    *    {
    *       'type': 'CalculationStep',
    *       'fields': {
    *          'source': 'srcval',
    *          'output': 'newval'
    *       }
    *    }
    * ]
    *
    * @param $stepConfig array - set of config data
    * @return array of CalculationSteps
    */
   public function generateStepList($stepConfig) {
      return array_map(function ($item) {
         return $this->generateStep($item['type'], $item['fields']);
      }, $stepConfig);
   }

   /**
    * Creates a CalculationStep.
    *
    * @param $type string - Name of the CalculationStep class
    * @param $fields array - Array of field names and properties
    * @return CalculationStep
    */
   public function generateStep($type, $fields) {
      return array_reduce(array_keys($fields), function ($step, $key) use ($fields) {
         $step->$key = $fields[$key];

         return $step;
      }, new $type());
   }
}
