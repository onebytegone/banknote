<?php

/**
 * @copyright 2015 Ethan Smith
 */

class CombineByKeyTest extends BaseTest {
   public function testTotalByKey() {
      $field = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(10, 1),
            $this->makeAmountEntry(10, 2)
         ),
         'none' => $this->makeStore(),
         'left' => $this->makeStore(
            $this->makeAmountEntry(4, 1),
            $this->makeAmountEntry(2, 3),
            $this->makeAmountEntry(2, 1)
         )
      );

      $additional = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(9, 1),
            $this->makeAmountEntry(7, 3)
         ),
         'none' => $this->makeStore(),
         'right' => $this->makeStore(
            $this->makeAmountEntry(2, 3),
            $this->makeAmountEntry(4, 12)
         )
      );

      $expected = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(10, 1),
            $this->makeAmountEntry(10, 2),
            $this->makeAmountEntry(9, 1),
            $this->makeAmountEntry(7, 3)
         ),
         'none' => $this->makeStore(),
         'left' => $this->makeStore(
            $this->makeAmountEntry(4, 1),
            $this->makeAmountEntry(2, 3),
            $this->makeAmountEntry(2, 1)
         ),
         'right' =>  $this->makeStore(
            $this->makeAmountEntry(2, 3),
            $this->makeAmountEntry(4, 12)
         )
      );

      $step = new CombineByKey();
      $step->source = 'field';
      $step->additional = 'additional';
      $step->output = 'output';

      $outputPackage = $step->calculate(array('field' => $field, 'additional' => $additional));

      $this->assertEquals($expected, $outputPackage['output']);
   }
}

