<?php

use PHPUnit\Framework\TestCase;
use Tyryshkinm\ExchangeRates\ExchangeRates;

class ExchangeRatesTest extends TestCase
{
    public function testGetAverageRates()
    {
        $date = new \DateTime('now');
        $averageRates = new ExchangeRates();
        $averageRates = $averageRates->getAverageRates($date);
        self::assertIsArray($averageRates);
    }
}