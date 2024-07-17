<?php

declare(strict_types=1);

namespace App\Core;

use App\Currency\Currency;
use function number_format;

class Money
{

    private readonly float $amount;
    private readonly Currency $currency;

    public function __construct(float $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function __toString(): string
    {
        return number_format($this->amount, 2, '.', '') . ' ' . $this->currency->getCode();
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function sumWith(Money $money): self
    {
        return new Money($this->amount + $money->getAmount(), $this->getCurrency());
    }

    public function subtractWith(Money $money): self
    {
        return new Money($this->amount - $money->getAmount(), $this->getCurrency());
    }

    public function exchange(Currency $currency): Money
    {
        return new Money($this->currency->getExchangeRate($currency) * $this->amount, $currency);
    }
}