<?php

/**
 * @copyright 2015 Ethan Smith
 */
class EntryFieldFormatterTest extends PHPUnit_Framework_TestCase {

   public function testFormat() {
      $entry = new stdClass();
      $entry->value = 20.123;
      $entry->alt = 123;
      $entry->color = 'blue';
      $entry->emptyInt = 0;
      $entry->emptyStr = '';
      $entry->nullField = null;

      // Defaults test
      $formatter = new EntryFieldFormatter();
      $this->assertEquals('20.123', $formatter->format($entry));

      // Config test
      $formatter = new EntryFieldFormatter('alt', '$%d');
      $this->assertEquals('$123', $formatter->format($entry));

      // Config test 2
      $formatter = new EntryFieldFormatter('color', 'my: %s');
      $this->assertEquals('my: blue', $formatter->format($entry));

      // Empty tests
      $formatter = new EntryFieldFormatter('emptyInt');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new EntryFieldFormatter('emptyStr');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->defaultReturn = 'cow';
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('cow', $formatter->format($entry));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->defaultReturn = 'cow';
      $this->assertEquals('cow', $formatter->format(null));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->defaultReturn = null;
      $this->assertNull($formatter->format(null));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->defaultReturn = 'dog';
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('dog', $formatter->format(null));

      $formatter = new EntryFieldFormatter('nullField');
      $formatter->defaultReturn = null;
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertNull($formatter->format($entry));
   }

   private function makeAmountEntry($value, $timePeriodIndex, $category = null) {
      $entry = new AmountEntry();
      $entry->amount = $value;
      if ($category) {
         $entry->source = $category;
      }
      $entry->timePeriod = TimePeriod::all_time_periods()[$timePeriodIndex];
      return $entry;
   }
}

