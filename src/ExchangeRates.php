<?php


namespace Tyryshkinm\ExchangeRates;


use Tyryshkinm\ExchangeRates\DTO\AverageRateDTO;
use Tyryshkinm\ExchangeRates\Exception\EmptyProviderListException;
use Tyryshkinm\ExchangeRates\Provider\ProviderInterface;

class ExchangeRates
{
    /**
     * @var ProviderInterface[]
     */
    private array $providers;

    public function __construct(ProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    /**
     * Public method for implementation your own provider.
     *
     * @param ProviderInterface $provider
     * @return void
     */
    public function addProvider(ProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    /**
     * Get average rates from providers by currency and date.
     *
     * @param string $currency
     * @param \DateTime $date
     * @return float|int
     * @throws EmptyProviderListException
     */
    public function getAverageRate(string $currency, \DateTime $date): AverageRateDTO
    {
        if (!$this->providers) {
            throw new EmptyProviderListException();
        }

        $sumRate = 0;
        foreach ($this->providers as $provider) {
            $sumRate += $provider->getRate($currency, $date);
        }

        $averageRate = $sumRate/count($this->providers);

        return new AverageRateDTO($date, $currency, $averageRate);
    }
}