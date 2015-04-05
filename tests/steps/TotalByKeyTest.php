<?php

/**
 * @copyright 2015 Ethan Smith
 */

class TotalByKeyTest extends BaseTest {
   public function testTotalByKey() {
      $field = array(
         'multi' => array(
            $this->makeStore(
               $this->makeAmountEntry(5, 1),
               $this->makeAmountEntry(5, 2),
               $this->makeAmountEntry(5, 10)
            ),
            $this->makeStore(
               $this->makeAmountEntry(5, 1),
               $this->makeAmountEntry(5, 2)
            )
         ),
         'single' => array(
            $this->makeStore(
               $this->makeAmountEntry(4, 1),
               $this->makeAmountEntry(2, 3),
               $this->makeAmountEntry(2, 1)
            )
         )
      );

      $expected = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(10, 1),
            $this->makeAmountEntry(10, 2),
            $this->makeAmountEntry(5, 10)
         ),
         'single' => $this->makeStore(
            $this->makeAmountEntry(6, 1),
            $this->makeAmountEntry(2, 3)
         )
      );

      $step = new TotalByKey();
      $step->source = 'field';
      $step->output = 'output';

      $outputPackage = $step->calculate(array('field' => $field));

      $this->assertEquals($expected, $outputPackage['output']);
   }
}

