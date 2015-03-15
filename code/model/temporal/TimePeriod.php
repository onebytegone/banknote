<?php

/**
 * Stores data about a given time range. Contains a pointer
 * to the last time range. When this TimePeriod is the first
 * the LastPeriod should point to a TimePeriod period for
 * the initial state of the sequence.
 *
 * @copyright 2015 Ethan Smith
 */

class TimePeriod {
    public $id = '';
    public $name = '';
    public $startDate = '';
    public $endDate = '';
    private $lastPeriod = null;
    public static $time_periods = null;

    function __construct($lastPeriod = null) {
    	$this->lastPeriod = $lastPeriod;
    }

    public function LastPeriod() {
    	return $this->lastPeriod;
    }

    static public function areEquivalent($a, $b) {
        return
            $a &&
            $b &&
            $a->id == $b->id &&
            $a->startDate == $b->startDate &&
            $a->endDate == $b->endDate;
    }

    public function compareTo($otherItem) {
        if ($this->startDate == $otherItem->startDate) {
            return 0;
        }

        return (strtotime($this->startDate) < strtotime($otherItem->startDate)) ? -1 : 1;
    }

    static public function all_time_periods($forceLoad = false) {
        if (self::$time_periods && !$forceLoad) {
            return self::$time_periods;
        }

        $rawData = file_get_contents(rtrim(__DIR__, '/').'/../../../data/time-periods.json');

        $jsonData = json_decode($rawData);

        $periods = array();

        foreach ($jsonData as $item) {
            $last = null;
            if ($item->prevID) {
                $last = self::findTimePeriodWithID($periods, $item->prevID);
            }

            $period = new TimePeriod($last);
            $period->id = $item->id;
            $period->name = $item->name;
            $period->startDate = $item->start;
            $period->endDate = $item->end;

            $periods[] = $period;
        }

        return $periods;
    }

    static public function findTimePeriodWithID($timePeriods, $id) {
        $foundItems = array_filter($timePeriods, function ($item) use ($id) {
            return $item->id == $id;
        });

        return array_shift($foundItems);
    }

    static public function findTimePeriodByMonthAndDay($timePeriods, $date) {
        $foundItems = array_filter($timePeriods, function ($item) use ($date) {
            return strtotime($item->startDate) <= strtotime($date) && strtotime($item->endDate) >= strtotime($date);
        });

        return array_shift($foundItems);
    }

    static public function fetchTimePeriodByMonthAndDay($date) {
        return self::findTimePeriodByMonthAndDay(self::all_time_periods(), $date);
    }


    /**
     * Builds an array of the the names of the given TimePeriods
     *
     * @param $timePeriods array - list of TimePeriods
     * @return array(string, ...)
     */
    static public function fetch_names($timePeriods = null) {
        if (!$timePeriods) {
            $timePeriods = self::all_time_periods();
        }

        return array_reduce($timePeriods, function($carry, $timePeriod) {
            // Skip 'Initial' time period
            if ($timePeriod->LastPeriod() == null) {
                return $carry;
            }

           $carry[] = $timePeriod->name;
           return $carry;
        }, array(''));
    }
}
