<?php

declare(strict_types=1);

namespace App\Currency;

use App\Core\Exception\NotAvailableForExchangeException;
use App\Core\Money;
use function is_float;

abstract class Currency
{
    private string $code;

    private array $exchangeRate;

    public function __construct(string $code)
    {
        if (!$code = trim($code)) {
            throw new \InvalidArgumentException('Currency code should not be empty string');
        }

        $this->code = $code;
        $this->exchangeRate[$this->code] = 1;
    }

    public function __invoke(float|Money $amount): Money
    {
        if (is_float($amount)) {
            return new Money($amount, $this);
        }

        return $amount->exchange($this);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setExchangeRate(Currency $currency, float $rate): void
    {
        if ($currency->getCode() === $this->getCode()) {
            throw new NotAvailableForExchangeException();
        }

        $this->exchangeRate[$currency->getCode()] = $rate;
    }

    public function getExchangeRate(Currency $currency): float
    {
        return $this->exchangeRate[$currency->getCode()]
            ?? throw new NotAvailableForExchangeException();
    }
}