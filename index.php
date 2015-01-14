<?php

require 'environment.php';
require 'code/require.php';

$timePeriods = TimePeriod::all_time_periods();

$a = new TemporalItem();
$a->id = "item_a";
$a->timePeriod = $timePeriods[0];
var_dump($a);
echo "<br>";

$b = new TemporalItem();
$b->id = "item_b";
$b->timePeriod = $timePeriods[1];

$c = new TemporalItem();
$c->id = "item_c";
$c->timePeriod = $timePeriods[1];

$items = array($a, $b, $c);
$store = new TemporalItemStore($items);

var_dump($store->itemsForTimePeriod($timePeriods[0]));
echo "<br>";
var_dump($store->itemsForTimePeriod($timePeriods[1]));
echo "<br>";
var_dump($store->itemsForTimePeriod($timePeriods[2]));
echo "<br>";
var_dump($store->itemsForTimePeriod($timePeriods[2]->LastPeriod()));
echo "<br>";
var_dump($store->itemWithID('item_b'));
