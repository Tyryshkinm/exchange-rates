<?php

namespace Tyryshkinm\ExchangeRates\Providers;


use Tyryshkinm\ExchangeRates\Http\Response;

class RBC implements Provider
{
    /**
     * Get rate from RBC.
     *
     * @param string $exchange
     * @param null $date
     * @return mixed
     */
    public function getRate($exchange = 'USD', $date = null)
    {
        $exchangeRate = null;
        if ($date) {
            $date = $date->format('Y-m-d');
        }

        $url = 'https://cash.rbc.ru/cash/json/converter_currency_rate';
        $query = [
            'currency_from' => $exchange,
            'date' => $date,
            'currency_to' => 'RUR',
            'source' => 'cbrf',
            'sum' => 1,
        ];

        $response = new Response();
        $response = $response->getResponse($url, $query);

        if ($response) {
            $json = json_decode($response->getBody()->getContents(), true);
            $exchangeRate = $json["data"]["sum_result"];
        }

        return $exchangeRate;
    }
}