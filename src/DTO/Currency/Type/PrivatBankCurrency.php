<?php

declare(strict_types=1);

namespace App\DTO\Currency\Type;

final class PrivatBankCurrency extends AbstractCurrency
{
    protected function getCurrency(array $data): array
    {
        return $this->getCurrencyByAlpha3($data['ccy']);
    }

    protected function getBaseCurrency(array $data): array
    {
        return $this->getCurrencyByAlpha3($data['base_ccy']);
    }

    protected function determineRateCross($data): float
    {
        return $this->calculateRateCross((float) $data['sale']);
    }

    protected function pickSalePrice($data): float
    {
        return (float) $data['sale'];
    }

    protected function pickBuyPrice($data): float
    {
        return (float) $data['buy'];
    }
}
