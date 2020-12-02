<?php


namespace Tyryshkinm\ExchangeRates\Exception;


/**
 * Exception for unavailable url content.
 *
 * Class UnavailableURLContentException
 * @package Tyryshkinm\ExchangeRates\Exception
 */
class UnavailableURLContentException extends \Exception
{
    public $message = 'URL content is not available.';
}