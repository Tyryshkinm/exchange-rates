<?php


namespace Tyryshkinm\ExchangeRates\Provider;


use Tyryshkinm\ExchangeRates\Exception\NoRateException;
use Tyryshkinm\ExchangeRates\Http\ClientInterface;

class RBCProvider implements ProviderInterface
{
    const URL = 'https://cash.rbc.ru/cash/json/converter_currency_rate';
    const DATE_FORMAT = 'Y-m-d';
    const CURRENCY_CODES_MAP = [
        'USD' => 'USD',
        'EUR' => 'EUR',
        'RUB' => 'RUR'
    ];
    const SOURCE = 'cbrf';
    const SUM = 1;

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
     * @param string $currencyFrom
     * @param \DateTime $date
     * @return string
     */
    private function getUrl(string $currencyFrom, \DateTime $date): string
    {
        $parameters = [
            'currency_from' => $currencyFrom,
            'currency_to'   => self::CURRENCY_CODES_MAP['RUB'],
            'source'        => self::SOURCE,
            'sum'           => self::SUM,
            'date'          => $date->format(self::DATE_FORMAT)
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
     * Parse json content.
     *
     * @param string $jsonContent
     * @return float
     * @throws NoRateException
     */
    private function parseJSONContent(string $jsonContent): float
    {
        $decodedJSONContent = json_decode($jsonContent, true);

        if (
            !is_array($decodedJSONContent) ||
            !array_key_exists('data', $decodedJSONContent) ||
            !array_key_exists('sum_result', $decodedJSONContent['data']) ||
            !$decodedJSONContent['data']['sum_result']
        ) {
            throw new NoRateException();
        }

        return $decodedJSONContent['data']['sum_result'];
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
        $url = $this->getUrl(self::CURRENCY_CODES_MAP[$currency], $date);
        $content = $this->getContent($url);

        return $this->parseJSONContent($content);
    }
}