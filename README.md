# banknote


Banknote is a simple personal finance tracking website. The data processing is based on a transactional processing model.

Things are still in development for this.


## Setup

Currently, a server with PHP is needed to use banknote.


## Compiling SCSS

[Compass](http://compass-style.org) is required to compile the SCSS into CSS.

Once compass is installed, the following command can be ran:

```
compass compile
```


## Unit Tests

The unit tests require PHPUnit. They can be ran by calling:
```
util/run-tests.sh
```


## Operations

### TotalForPeriod
| Field  | Type              |
| ------ | ----------------- |
| source | TemporalItemStore |
| output | TemporalItemStore |

This takes all of the AmountEntries per TimePeriod and sums their values together. The resulting value is placed in a new TemporalItemStore for the same TimePeriod.

Example:
```
// d Source:
TemporalItemStore {
   'jan': [ 5, 6, 7 ],
   'feb': [],
   'mar': [ 2 ]
}

// Output:
TemporalItemStore {
   'jan': [ 18 ],
   'feb': [],
   'mar': [ 2 ]
}
```

### DifferenceOfStores
| Field      | Type              |
| ---------- | ----------------- |
| source     | TemporalItemStore |
| subtrahend | TemporalItemStore |
| output     | TemporalItemStore |

This takes one AmountEntry per TimePeriod from `source` and `subtrahend`. The the value for `subtrahend` is subtracted from `source`. The value is put into a new each AmountEntry and is placed in a new TemporalItemStore for the same TimePeriod.

Example:
```
// Source:
TemporalItemStore {
   'jan': [ 5 ],
   'feb': [],
   'mar': [ 2 ]
}

// Subtrahend:
TemporalItemStore {
   'jan': [ 1 ],
   'feb': [ 7 ],
   'mar': [ 2 ]
}

// Output:
TemporalItemStore {
   'jan': [ 4 ],
   'feb': [ -7 ],
   'mar': [ 0 ]
}
```
