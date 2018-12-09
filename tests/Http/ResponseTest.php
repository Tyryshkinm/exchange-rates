<?php

use PHPUnit\Framework\TestCase;
use Tyryshkinm\ExchangeRates\Http\Response;

class ResponseTest extends TestCase
{
    public function testGetResponse()
    {
        $response = new Response();
        $response = $response->getResponse('https://google.com');
        self::assertEquals(200, $response->getStatusCode());
    }
}