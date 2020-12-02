<?php


namespace Tyryshkinm\ExchangeRates\Http;


use Tyryshkinm\ExchangeRates\Exception\UnavailableURLContentException;

/**
 * Class Client
 * @package Tyryshkinm\ExchangeRates\Http
 */
class Client implements ClientInterface
{
    /**
     * Simple implementation for getting the url content.
     *
     * @param string $url
     * @return string
     * @throws UnavailableURLContentException
     */
    public function get(string $url): string
    {
        $content = file_get_contents($url);
        if (!$content) {
            throw new UnavailableURLContentException();
        }

        return $content;
    }
}