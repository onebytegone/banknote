<?php

/**
 * @copyright 2015 Ethan Smith
 */
class InterfaceCreator {
   public $generators = array();

   public function buildInterface($package) {
      return join("\n", array_map(function ($generator) use ($package) {
         return $generator->generate($package);
      }, $this->generators));
   }
}
