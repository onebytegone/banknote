<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TimePeriodTest extends PHPUnit_Framework_TestCase {

   public function testAreEquivalent() {
      $janPeriod = new TimePeriod();
      $janPeriod->id = "jan";
      $janPeriod->name = "January";
      $janPeriod->startDate = "1/1";
      $janPeriod->endDate = "1/31";

      $janDiffPeriod = new TimePeriod(new TimePeriod());
      $janDiffPeriod->id = "jan";
      $janDiffPeriod->name = "My January";
      $janDiffPeriod->startDate = "1/1";
      $janDiffPeriod->endDate = "1/31";

      $idDiffPeriod = new TimePeriod();
      $idDiffPeriod->id = "jan2";
      $idDiffPeriod->name = "January";
      $idDiffPeriod->startDate = "1/1";
      $idDiffPeriod->endDate = "1/31";

      $febPeriod = new TimePeriod();
      $febPeriod->id = "feb";
      $febPeriod->name = "Febuary";
      $febPeriod->startDate = "2/1";
      $febPeriod->endDate = "2/29";

      $this->assertTrue(TimePeriod::areEquivalent($janPeriod, $janDiffPeriod));
      $this->assertFalse(TimePeriod::areEquivalent($janPeriod, $idDiffPeriod));
      $this->assertFalse(TimePeriod::areEquivalent($janPeriod, $febPeriod));
   }
}

