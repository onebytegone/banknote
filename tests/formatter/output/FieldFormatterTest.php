<?php

/**
 * @copyright 2015 Ethan Smith
 */
class FieldFormatterTest extends PHPUnit_Framework_TestCase {

   public function testFormat() {
      $entry = new stdClass();
      $entry->value = 20.123;
      $entry->alt = 123;
      $entry->color = 'blue';
      $entry->emptyInt = 0;
      $entry->emptyStr = '';
      $entry->nullField = null;

      // Defaults test
      $formatter = new FieldFormatter();
      $this->assertEquals(20.123, $formatter->format($entry));

      // Config test
      $formatter = new FieldFormatter('alt');
      $this->assertEquals(123, $formatter->format($entry));

      // Empty tests
      $formatter = new FieldFormatter('emptyInt');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new FieldFormatter('emptyStr');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new FieldFormatter('nullField');
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('', $formatter->format($entry));

      $formatter = new FieldFormatter('nullField');
      $formatter->defaultReturn = 'cow';
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('cow', $formatter->format($entry));

      $formatter = new FieldFormatter('nullField');
      $formatter->defaultReturn = 'cow';
      $this->assertEquals('cow', $formatter->format(null));

      $formatter = new FieldFormatter('nullField');
      $formatter->defaultReturn = null;
      $this->assertNull($formatter->format(null));

      $formatter = new FieldFormatter('nullField');
      $formatter->defaultReturn = 'dog';
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertEquals('dog', $formatter->format(null));

      $formatter = new FieldFormatter('nullField');
      $formatter->defaultReturn = null;
      $formatter->returnDefaultWhenEmpty = true;
      $this->assertNull($formatter->format($entry));
   }
}

