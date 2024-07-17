<?php

declare(strict_types=1);

namespace App\Core;


use function array_filter;
use function array_map;
use const ARRAY_FILTER_USE_KEY;

use App\Currency\Currency;
use App\Core\Exception\CurrencyAlreadyAddedException;

class Account
{
    public Currency $baseCurrency;

    /** @var Money[] $money */
    private array $money;

    /** @var Currency[] $currencies */
    private array $currencies;

    public function __construct()
    {
    }

    /**
     * @return Currency
     */
    public function getBaseCurrency(): Currency
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency($currency): void
    {
        $this->baseCurrency = $currency;
        if (!isset($this->balance)) {
            $this->balance = $this->getBalance();
        }
    }

    public function addCurrency(Currency $currency): void
    {
        if (isset($this->currencies[$currency->getCode()])) {
            throw new CurrencyAlreadyAddedException();
        }

        $this->currencies[$currency->getCode()] ??= $currency;
        $this->initMoney($currency);
    }

    public function removeCurrency(Currency $currency): void
    {
        unset($this->currencies[$currency->getCode()]);
    }

    public function getSupportedCurrencies(): array
    {
        return $this->currencies;
    }

    public function refillBalance(Money $money): void
    {
        $currencyCode = $money->getCurrency()->getCode();

        $this->money[$currencyCode] = $this->money[$currencyCode]->sumWith($money);
    }

    public function deductMoney(Money $money): Money
    {
        $currencyCode = $money->getCurrency()->getCode();

        $this->money[$currencyCode] = $this->money[$currencyCode]->subtractWith($money);

        return $money;
    }

    public function getBalance(?Currency $currency = null): Money
    {
        $currency ??= $this->getBaseCurrency();

        $balance = $this->money[$currency->getCode()];

        array_map(
            static function (Money $money) use (&$balance, $currency) {
                $balance = $balance->sumWith($money->exchange($currency));
            },
            array_filter(
                $this->money,
                static fn(string $code) => $code !== $currency->getCode(),
                ARRAY_FILTER_USE_KEY
            )
        );

        return $balance;
    }

    private function initMoney(Currency $currency): void
    {
        $this->money[$currency->getCode()] ??= new Money(0, $currency);
    }
}