<?php

/**
 * @copyright 2015 Ethan Smith
 */
class PrimitiveFieldFormatterTest extends PHPUnit_Framework_TestCase {

   public function testFormat() {
      $entry = new stdClass();
      $entry->value = 20.123;
      $entry->alt = 123;
      $entry->color = 'blue';

      // Defaults test
      $formatter = new PrimitiveFieldFormatter();
      $this->assertEquals('20.123', $formatter->format($entry));

      // Config test
      $formatter = new PrimitiveFieldFormatter('alt', '$%d');
      $this->assertEquals('$123', $formatter->format($entry));

      // Config test 2
      $formatter = new PrimitiveFieldFormatter('color', 'my: %s');
      $this->assertEquals('my: blue', $formatter->format($entry));
   }
}

