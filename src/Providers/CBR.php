<?php

namespace Tyryshkinm\ExchangeRates\Providers;


use Tyryshkinm\ExchangeRates\Http\Response;

class CBR implements Provider
{
    /**
     * Get rate from CBR.
     *
     * @param string $exchange
     * @param null $date
     * @return float
     */
    public function getRate($exchange = 'USD', $date = null):float
    {
        $exchangeRate = null;
        if ($date) {
            $date = $date->format('d/m/Y');
        }

        $url = 'http://www.cbr.ru/scripts/XML_daily_eng.asp';
        $query = [
            'date_req' => $date,
        ];

        $response = new Response();
        $response = $response->getResponse($url, $query);
        if ($response) {
            $xml = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
            $json = json_encode($xml);
            $json = json_decode($json, true);
            foreach ($json["Valute"] as $valute) {
                if ($exchange === $valute["CharCode"]) {
                    $exchangeRate = str_replace(',', '.', $valute["Value"]);
                }
            }
        }

        return $exchangeRate;
    }
}