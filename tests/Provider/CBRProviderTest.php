<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tyryshkinm\ExchangeRates\Exception\NoRateException;
use Tyryshkinm\ExchangeRates\Http\ClientInterface;
use Tyryshkinm\ExchangeRates\Provider\CBRProvider;

class CBRProviderTest extends TestCase
{
    const CURRENCY = 'USD';

    /**
     * @var MockObject|ClientInterface
     */
    private $client;

    /**
     * @var CBRProvider
     */
    private $provider;

    /**
     * @var DateTime
     */
    private $date;

    protected function setUp(): void
    {
        $this->client = $this->createMock(ClientInterface::class);
        $this->provider = new CBRProvider($this->client);
        $this->date = new \DateTime('2020-12-02');
    }

    public function testGetRate()
    {
        $content = <<<'EOD'
            <ValCurs ID="R01235" DateRange1="02.12.2020" DateRange2="02.12.2020" name="Foreign Currency Market Dynamic">
                <Record Date="02.12.2020" Id="R01235">
                    <Nominal>1</Nominal>
                    <Value>76,3203</Value>
                </Record>
            </ValCurs>
        EOD;
        $this->client->method('get')->willReturn($content);
        $actualRate = $this->provider->getRate(self::CURRENCY, $this->date);
        $this->assertEquals('76.3203', $actualRate);
    }

    public function testParseXmlContentNoRateException()
    {
        $this->expectException(NoRateException::class);
        $this->expectExceptionMessage('No rate returned by provider.');
        $this->provider->getRate(self::CURRENCY, (new \DateTime('now'))->modify('+1 year'));
    }
}