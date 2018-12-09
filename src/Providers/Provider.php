<?php

namespace Tyryshkinm\ExchangeRates\Providers;


interface Provider
{
    public function getRate($exchange, $date);
}