<?php

declare(strict_types=1);

namespace App\Core\Exception;

class NotAvailableForExchangeException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('This currency is not available for exchange');
    }
}