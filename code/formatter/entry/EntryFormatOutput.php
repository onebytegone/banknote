<?php

/**
 * Defines the EntryFormatOutput protocol
 *
 * @copyright 2015 Ethan Smith
 */

interface EntryFormatOutput {
    public function formatObject($object);
    public function formatListOfObjects($objects);
}
