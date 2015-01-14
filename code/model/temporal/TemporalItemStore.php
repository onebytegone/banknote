<?php

/**
 * Stores a set of TemporalItems. Allows lookup by TimePeriod.
 *
 * @copyright 2015 Ethan Smith
 */

class TemporalItemStore {
    private $items = array();

    function __construct($items) {
        $this->items = $items;
    }

    public function itemsForTimePeriod($timePeriod) {
    	return array_filter($this->items, function ($item) use ($timePeriod) {
            return TimePeriod::compare($item->timePeriod, $timePeriod);
        });
    }

    public function itemWithID($id) {
    	$foundItems = array_filter($this->items, function ($item) use ($id) {
            return $item->id == $id;
        });

        return array_shift($foundItems);
    }
}
