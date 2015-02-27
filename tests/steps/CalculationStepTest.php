<?php

/**
 * @copyright 2015 Ethan Smith
 */
class CalculationStepTest extends PHPUnit_Framework_TestCase {

   public function testDuplicateFieldWithVar() {
      $package = array(
         'field' => 5,
         );

      $newPackage = CalculationStep::duplicate_field($package, 'field', 'new');

      $package['field'] = 0;

      $this->assertNotEquals($package, $newPackage);
      $this->assertEquals(5, $newPackage['field']);
      $this->assertEquals(5, $newPackage['new']);
   }

   public function testDuplicateFieldWithObj() {
      $package = array(
         'obj' => new stdClass(),
         );
      $package['obj']->value = 5;

      $newPackage = CalculationStep::duplicate_field($package, 'obj', 'new');

      $package['obj']->value = 0;

      $this->assertNotEquals($package, $newPackage);
      $this->assertEquals(0, $newPackage['obj']->value);
      $this->assertEquals(0, $newPackage['new']->value);
   }
}

