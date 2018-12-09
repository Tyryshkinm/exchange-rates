<?php

namespace Tyryshkinm\ExchangeRates\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Response
{
    /**
     * Get response for providers.
     *
     * @param $url
     * @param $query
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function getResponse($url, $query = null)
    {
        $response = null;
        $client = new Client();
        try {
            $response = $client->get($url, [
                'query' => $query,
                'http_errors' => false,
            ]);
        }
        catch (RequestException $e) {
            if ($e->hasResponse()) {
                $exception = $e->getResponse()->getBody();
                echo $exception;
            } else {
                $exception = $e->getMessage();
                echo $exception;
            }
        }

        return $response;
    }
}