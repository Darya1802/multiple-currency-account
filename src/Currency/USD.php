<?php

declare(strict_types=1);

namespace App\Currency;

class USD extends Currency
{
    public function __construct()
    {
        parent::__construct(code: 'USD');
    }
}