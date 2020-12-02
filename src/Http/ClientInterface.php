<?php


namespace Tyryshkinm\ExchangeRates\Http;


/**
 * Interface ClientInterface
 * @package Tyryshkinm\ExchangeRates\Http
 */
interface ClientInterface
{
    /**
     * Get url content interface method.
     *
     * @param string $url
     * @return string
     */
    public function get(string $url): string;
}