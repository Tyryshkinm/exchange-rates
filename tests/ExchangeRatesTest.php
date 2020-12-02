<?php

use PHPUnit\Framework\TestCase;
use Tyryshkinm\ExchangeRates\DTO\AverageRateDTO;
use Tyryshkinm\ExchangeRates\Exception\EmptyProviderListException;
use Tyryshkinm\ExchangeRates\ExchangeRates;
use Tyryshkinm\ExchangeRates\Provider\ProviderInterface;

class ExchangeRatesTest extends TestCase
{
    const CURRENCY = 'USD';

    /**
     * @var DateTime
     */
    private $date;

    protected function setUp(): void
    {
        $this->date = new \DateTime();
    }

    public function testGetAverageRate()
    {
        $firstProviderRate = 10.10;
        $secondProviderRate = 20.20;

        $firstProvider = $this->createMock(ProviderInterface::class);
        $secondProvider = $this->createMock(ProviderInterface::class);

        $firstProvider->method('getRate')->willReturn($firstProviderRate);
        $secondProvider->method('getRate')->willReturn($secondProviderRate);

        $exchangeRates = new ExchangeRates($firstProvider, $secondProvider);
        $actualAverageRate = $exchangeRates->getAverageRate(self::CURRENCY, $this->date);

        $expectedAverageRate = new AverageRateDTO($this->date, self::CURRENCY, 15.15);

        $this->assertEquals($expectedAverageRate, $actualAverageRate);
    }

    public function testGetAverageRateEmptyProviderListException()
    {
        $this->expectException(EmptyProviderListException::class);
        $this->expectExceptionMessage('Provider list is empty.');
        $exchangeRate = new ExchangeRates();
        $exchangeRate->getAverageRate(self::CURRENCY, $this->date);
    }
}