<?php

declare(strict_types=1);

namespace App\Core\Exception;

class CurrencyAlreadyAddedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Currency already added');
    }
}