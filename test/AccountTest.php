<?php

declare(strict_types=1);

use App\Core\Account;
use App\Currency\EUR;
use App\Currency\RUB;

class AccountTest extends \PHPUnit\Framework\TestCase
{
    private Account $account;
    private RUB $rub;
    private EUR $eur;

    protected function setUp(): void
    {
        $this->account = new Account();
        $this->rub = new RUB();
        $this->eur = new EUR();
    }

    protected function tearDown(): void
    {
        $this->account = NUll;
    }

    public function testAddCurrency(): void
    {
        $this->account->addCurrency($this->rub);
        $this->account->addCurrency($this->eur);
        $this->assertEquals($this->account->getSupportedCurrencies(), [$this->rub, $this->eur]);
    }

     public function testRemoveCurrency(): void
    {
        $this->account->removeCurrency($this->eur);
        $this->assertEquals($this->account->getSupportedCurrencies(), [$this->rub]);
    }


    public function testSetBaseCurrency(): void
    {
        $this->account->setBaseCurrency($this->rub);
        $this->assertEquals($this->account->getBaseCurrency(), $this->rub);
    }

    public function testRefillBalance(): void
    {
        $this->account->refillBalance($this->rub(1000));
        $this->assertEquals(1000, $this->account->getBalance($this->rub));
    }

     public function DeductBalance(): void
    {
        $this->account->deductBalance($this->rub(500));
        $this->assertEquals(500, $this->account->getBalance($this->rub));
    }
}