<?php


namespace Tyryshkinm\ExchangeRates\Provider;


use Tyryshkinm\ExchangeRates\Exception\NoRateException;
use Tyryshkinm\ExchangeRates\Http\ClientInterface;

class CBRProvider implements ProviderInterface
{
    const URL = 'http://www.cbr.ru/scripts/XML_dynamic.asp';
    const DATE_FORMAT = 'd/m/Y';
    const CURRENCY_CODES_MAP = [
        'USD' => 'R01235',
        'EUR' => 'R01239'
    ];

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get url address by currency and date.
     *
     * @param string $currencyCode
     * @param \DateTime $date
     * @return string
     */
    private function getURL(string $currencyCode, \DateTime $date): string
    {
        $dateReq1 = $date->format(self::DATE_FORMAT);
        $dateReq2 = $dateReq1;

        $parameters = [
            'date_req1' => $dateReq1,
            'date_req2' => $dateReq2,
            'VAL_NM_RQ' => $currencyCode
        ];

        return self::URL . '?' . http_build_query($parameters);
    }

    /**
     * Get url content.
     *
     * @param string $url
     * @return string
     */
    private function getContent(string $url): string
    {
        return $this->client->get($url);
    }

    /**
     * Parse xml content.
     *
     * @param string $xmlContent
     * @return float
     * @throws NoRateException
     */
    private function parseXmlContent(string $xmlContent): float
    {
        $xmlObject = simplexml_load_string($xmlContent);
        $decodedXmlObject = json_decode(json_encode($xmlObject), true);

        if (
            !is_array($decodedXmlObject) ||
            !array_key_exists('Record', $decodedXmlObject) ||
            !array_key_exists('Value', $decodedXmlObject['Record']) ||
            !$decodedXmlObject['Record']['Value']
        ) {
            throw new NoRateException();
        }

        return floatval(str_replace(',', '.', $decodedXmlObject['Record']['Value']));
    }

    /**
     * Get rate by currency and date.
     *
     * @param string $currency
     * @param \DateTime $date
     * @return float
     * @throws NoRateException
     */
    public function getRate(string $currency, \DateTime $date): float
    {
        $url = $this->getURL(self::CURRENCY_CODES_MAP[$currency], $date);
        $content = $this->getContent($url);

        return $this->parseXmlContent($content);
    }
}