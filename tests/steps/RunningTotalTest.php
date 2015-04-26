<?php

/**
 * @copyright 2015 Ethan Smith
 */

class RunningTotalTest extends BaseTest {
   public function testRunningTota() {
      $field = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(10, 1),
            $this->makeAmountEntry(10, 2)
         ),
         'none' => $this->makeStore(),
         'extras' => $this->makeStore(
            $this->makeAmountEntry(4, 1),
            $this->makeAmountEntry(2, 3),
            $this->makeAmountEntry(2, 1),
            $this->makeAmountEntry(-2, 7),
            $this->makeAmountEntry(5, 10)
         )
      );

      $expected = array(
         'multi' => $this->makeStore(
            $this->makeAmountEntry(0, 0),
            $this->makeAmountEntry(10, 1),
            $this->makeAmountEntry(20, 2),
            $this->makeAmountEntry(20, 3),
            $this->makeAmountEntry(20, 4),
            $this->makeAmountEntry(20, 5),
            $this->makeAmountEntry(20, 6),
            $this->makeAmountEntry(20, 7),
            $this->makeAmountEntry(20, 8),
            $this->makeAmountEntry(20, 9),
            $this->makeAmountEntry(20, 10),
            $this->makeAmountEntry(20, 11),
            $this->makeAmountEntry(20, 12)
         ),
         'none' => $this->makeStore(
            $this->makeAmountEntry(0, 0),
            $this->makeAmountEntry( 0, 1),
            $this->makeAmountEntry(0, 2),
            $this->makeAmountEntry(0, 3),
            $this->makeAmountEntry(0, 4),
            $this->makeAmountEntry(0, 5),
            $this->makeAmountEntry(0, 6),
            $this->makeAmountEntry(0, 7),
            $this->makeAmountEntry(0, 8),
            $this->makeAmountEntry(0, 9),
            $this->makeAmountEntry(0, 10),
            $this->makeAmountEntry(0, 11),
            $this->makeAmountEntry(0, 12)
         ),
         'extras' => $this->makeStore(
            $this->makeAmountEntry(0, 0),
            $this->makeAmountEntry(6, 1),
            $this->makeAmountEntry(6, 2),
            $this->makeAmountEntry(8, 3),
            $this->makeAmountEntry(8, 4),
            $this->makeAmountEntry(8, 5),
            $this->makeAmountEntry(8, 6),
            $this->makeAmountEntry(6, 7),
            $this->makeAmountEntry(6, 8),
            $this->makeAmountEntry(6, 9),
            $this->makeAmountEntry(11, 10),
            $this->makeAmountEntry(11, 11),
            $this->makeAmountEntry(11, 12)
         )
      );

      $step = new RunningTotal();
      $step->source = 'field';
      $step->output = 'output';

      $outputPackage = $step->calculate(array('field' => $field));

      $this->assertEquals($expected, $outputPackage['output']);
   }
}

