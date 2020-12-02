<?php


namespace Tyryshkinm\ExchangeRates\Exception;


/**
 * Exception for provider list is empty.
 *
 * Class EmptyProviderListException
 * @package Tyryshkinm\ExchangeRates\Exception
 */
class EmptyProviderListException extends \Exception
{
    public $message = 'Provider list is empty.';
}