<?php


namespace Tyryshkinm\ExchangeRates\Provider;


/**
 * Interface ProviderInterface
 * @package Tyryshkinm\ExchangeRates\Provider
 */
interface ProviderInterface
{
    /**
     * Get rate by currency and date interface method.
     *
     * @param string $currency
     * @param \DateTime $date
     * @return float
     */
    public function getRate(string $currency, \DateTime $date): float;
}