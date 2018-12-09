## Installation

```
$ composer require tyryshkinm/exchange-rates
```

## Usage

```php
use Tyryshkinm\ExchangeRates\ExchangeRates;

$date = new \DateTime('2011-01-01');
$exchangeRates = ExchangeRates::getAverageRates($date);