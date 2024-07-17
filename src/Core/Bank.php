<?php

declare(strict_types=1);

namespace App\Core;

class Bank
{
    public function openAccount(): Account
    {
        return new Account();
    }
}