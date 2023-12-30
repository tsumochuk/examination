<?php

namespace App\Service\Currency\BankService\Interfaces;

use App\DTO\Currency\Collection;

interface BankCurrenciesInterface
{
    public function fetchAllCurrencies(): Collection;
}
