<?php

namespace Tyryshkinm\ExchangeRates;


use Tyryshkinm\ExchangeRates\Providers\CBR;
use Tyryshkinm\ExchangeRates\Providers\RBC;

class ExchangeRates
{
    /**
     * Get average rates from providers.
     *
     * @param null $date
     * @return array
     */
    public function getAverageRates ($date)
    {
        if (!$date instanceof \DateTime) {
            $date = null;
        }

        $cbr = new CBR();
        $usdCbr = $cbr->getRate('USD', $date);
        $eurCbr = $cbr->getRate('EUR', $date);

        $rbc = new RBC();
        $usdRbc = $rbc->getRate('USD', $date);
        $eurRbc = $rbc->getRate('EUR', $date);

        $usdRates = [$usdCbr, $usdRbc];
        $averageUsdRates = array_sum($usdRates)/count($usdRates);

        $eurRates = [$eurCbr, $eurRbc];
        $averageEurRates = array_sum($eurRates)/count($eurRates);

        $averageRates = ['USD' => $averageUsdRates, 'EUR' => $averageEurRates];

        return $averageRates;
    }
}