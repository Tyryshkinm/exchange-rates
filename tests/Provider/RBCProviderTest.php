<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tyryshkinm\ExchangeRates\Exception\NoRateException;
use Tyryshkinm\ExchangeRates\Http\ClientInterface;
use Tyryshkinm\ExchangeRates\Provider\RBCProvider;

class RBCProviderTest extends TestCase
{
    const CURRENCY = 'USD';

    /**
     * @var MockObject|ClientInterface
     */
    private $client;

    /**
     * @var RBCProvider
     */
    private $provider;

    /**
     * @var DateTime
     */
    private $date;

    protected function setUp(): void
    {
        $this->client = $this->createMock(ClientInterface::class);
        $this->provider = new RBCProvider($this->client);
        $this->date = new \DateTime('2020-12-02');
    }

    public function testGetRate()
    {
        $content = '{"status": 200, "meta": {"sum_deal": 1.0, "source": "cbrf", "currency_from": "USD", "date": null, "currency_to": "RUR"}, "data": {"date": "2020-12-02 13:55:40", "sum_result": 76.3203, "rate1": 76.3203, "rate2": 0.0131}}';
        $this->client->method('get')->willReturn($content);
        $actualRate = $this->provider->getRate(self::CURRENCY, $this->date);
        $this->assertEquals('76.3203', $actualRate);
    }

    public function testParseJSONContentNoRateException()
    {
        $this->expectException(NoRateException::class);
        $this->expectExceptionMessage('No rate returned by provider.');
        $this->provider->getRate(self::CURRENCY, (new \DateTime('now'))->modify('+1 year'));
    }
}