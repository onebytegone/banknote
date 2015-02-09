<?php

/**
 * @copyright 2015 Ethan Smith
 */
class TimePeriodTest extends PHPUnit_Framework_TestCase {

   public function testFindByIDInArray() {
      $item = new TimePeriod();
      $item->id = "myid";
      $item2 = new TimePeriod();
      $item2->id = "randid";

      $items = array($item, $item2);
      $this->assertEquals($item, TimePeriod::findTimePeriodWithID($items, "myid"));
      $this->assertEquals($item2, TimePeriod::findTimePeriodWithID($items, "randid"));
      $this->assertNull(TimePeriod::findTimePeriodWithID($items, "notfound"));
   }

   public function testCompareTo() {
      $janPeriod = new TimePeriod();
      $janPeriod->startDate = "1/1";
      $janPeriod->endDate = "1/31";

      $janDupPeriod = new TimePeriod();
      $janDupPeriod->startDate = "1/1";
      $janDupPeriod->endDate = "1/31";

      $febPeriod = new TimePeriod();
      $febPeriod->startDate = "2/1";
      $febPeriod->endDate = "2/29";

      $marchPeriod = new TimePeriod();
      $marchPeriod->startDate = "3/1";
      $marchPeriod->endDate = "3/31";

      $twoMonths = new TimePeriod();
      $twoMonths->startDate = "2/1";
      $twoMonths->endDate = "4/1";


      $this->assertEquals(0, $janPeriod->compareTo($janDupPeriod));
      $this->assertEquals(1, $febPeriod->compareTo($janPeriod));
      $this->assertEquals(-1, $janPeriod->compareTo($febPeriod));
      $this->assertEquals(-1, $janPeriod->compareTo($marchPeriod));
      $this->assertEquals(-1, $janPeriod->compareTo($twoMonths));
      $this->assertEquals(0, $febPeriod->compareTo($twoMonths));
      $this->assertEquals(1, $marchPeriod->compareTo($twoMonths));
  }

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

