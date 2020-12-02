<?php


namespace Tyryshkinm\ExchangeRates\Factory;


use Tyryshkinm\ExchangeRates\Http\ClientInterface;
use Tyryshkinm\ExchangeRates\Provider\CBRProvider;
use Tyryshkinm\ExchangeRates\Provider\RBCProvider;

class ProviderFactory
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return [
            new CBRProvider($this->client),
            new RBCProvider($this->client)
        ];
    }
}