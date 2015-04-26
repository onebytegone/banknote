<?php

/**
 * @copyright 2015 Ethan Smith
 */

class AmountEntryTest extends BaseTest {
   public function testCompare() {
      $this->assertTrue(AmountEntry::compare(
         $this->makeAmountEntry(10, 2),
         $this->makeAmountEntry(10, 2)
      ));

      $this->assertTrue(AmountEntry::compare(
         $this->makeAmountEntry(5, 0),
         $this->makeAmountEntry(5, 0)
      ));

      $this->assertFalse(AmountEntry::compare(
         $this->makeAmountEntry(10, 1),
         $this->makeAmountEntry(10, 2)
      ));

      $this->assertFalse(AmountEntry::compare(
         $this->makeAmountEntry(10, 1),
         $this->makeAmountEntry(5, 1)
      ));
   }
}

