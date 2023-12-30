<?php

declare(strict_types=1);

namespace App\DTO\Currency\Type;

final class MonoBankCurrency extends AbstractCurrency
{
    protected function getCurrency(array $data): array
    {
        return $this->getCurrencyByCode($data['currencyCodeA']);
    }

    protected function getBaseCurrency(array $data): array
    {
        return $this->getCurrencyByCode($data['currencyCodeB']);
    }

    protected function determineRateCross($data): float
    {
        return $data['rateCross'] ?? $this->calculateRateCross($data['rateSell']);
    }

    protected function pickSalePrice($data): float
    {
        return $data['rateSell'];
    }

    protected function pickBuyPrice($data): float
    {
        return $data['rateBuy'];
    }
}
