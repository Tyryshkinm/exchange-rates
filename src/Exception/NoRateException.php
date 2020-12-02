<?php


namespace Tyryshkinm\ExchangeRates\Exception;


/**
 * Exception for no providers rate.
 *
 * Class NoRateException
 * @package Tyryshkinm\ExchangeRates\Exception
 */
class NoRateException extends \Exception
{
    public $message = 'No rate returned by provider.';
}