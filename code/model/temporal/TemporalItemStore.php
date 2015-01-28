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

    /**
     * Returns all the stored objects sorted by time period.
     *
     * @return array - list of items stored
     */
    public function allItems() {
        return TemporalItemStore::sort_items_by_time_period($this->items);
    }

    /**
     * Stores the given item.
     *
     * @param $item object - item to store
     */
    public function storeItem($item) {
        $this->items[] = $item;
    }

    public function anyItemForTimePeriod($timePeriod) {
        return array_shift($this->itemsForTimePeriod($timePeriod));
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

    public function generateValueSummary($formatter, $timePeriods) {
        $self = $this;
        $summary = array_reduce($timePeriods, function($carry, $timePeriod) use ($self, $formatter) {
            $entries = $self->itemsForTimePeriod($timePeriod);
            $carry[] = $formatter->formatListOfObjects($entries);

            return $carry;
        }, array());
        return $summary;
    }

    static public function sort_items_by_time_period($items) {
        // TODO: sort
        return $items;
    }
}
