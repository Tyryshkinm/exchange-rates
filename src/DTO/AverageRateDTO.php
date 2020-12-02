<?php


namespace Tyryshkinm\ExchangeRates\DTO;


class AverageRateDTO
{
    /**
     * @var \DateTime
     */
    private \DateTime $date;

    /**
     * @var string
     */
    private string $currencyFrom;

    /**
     * @var float
     */
    private float $averageRate;

    public function __construct(\DateTime $date, string $currencyFrom, float $averageRate)
    {
        $this->date = $date;
        $this->currencyFrom = $currencyFrom;
        $this->averageRate = $averageRate;
    }

    /**
     * @return float
     */
    public function getAverageRate(): float
    {
        return $this->averageRate;
    }

    /**
     * @return string
     */
    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}