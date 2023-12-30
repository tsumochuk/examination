<?php

namespace App\DTO\Currency;

use App\DTO\Currency\Type\CurrencyInterface;
use App\Enum\BankTypeEnum;

interface CollectionInterface
{
    /**
     * @return CurrencyInterface[]
     */
    public function getStore(): array;

    public function getBank(): BankTypeEnum;
}
