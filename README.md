## Installation

```
$ composer require tyryshkinm/exchange-rates
```

## Usage

```php
use Tyryshkinm\ExchangeRates\ExchangeRates;
use Tyryshkinm\ExchangeRates\Factory\ProviderFactory;
use Tyryshkinm\ExchangeRates\Http\Client;

$currency = 'USD'; // USD and EUR are available only.
$date = new \DateTime();
$client = new Client();
$providerFactory = new ProviderFactory($client);
$exchangeRateModel = new ExchangeRates(...$providerFactory->getProviders());

// for adding your own provider
$myOwnProvider = new MyOwnProvider(); // need implement ProviderInterface
$exchangeRateModel->addProvider($myOwnProvider);

$rate = $exchangeRateModel->getAverageRate($currency, $date);