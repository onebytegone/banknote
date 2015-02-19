<?php

/**
 * Parses the config file and creates the objects as needed.
 *
 * @copyright 2015 Ethan Smith
 */

class MasterConfigParser {
   public $configData = null;

   /**
    * Imports the given config
    *
    * @param $configFile string - Path to config file
    */
   function __construct($configFile = null) {
      if ($configFile) {
         $rawData = file_get_contents($configFile);
         $this->configData = json_decode($rawData, true);
      }
   }

   public function configForUIFields() {
      return $configData['ui-fields'];
   }

}
