<?php

/**
 * Stores expense data.
 *
 * @copyright 2015 Ethan Smith
 */

class ExpenseEntry extends TemporalItem {
    public $name = '';
    public $fundID = '';
    public $amount = 0;
    public $date = '';
    public $notes = '';
}
