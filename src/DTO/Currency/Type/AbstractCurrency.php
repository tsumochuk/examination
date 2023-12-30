<?php

declare(strict_types=1);

namespace App\DTO\Currency\Type;

use Alcohol\ISO4217;

abstract class AbstractCurrency implements CurrencyInterface
{
    protected readonly string $baseCurrencyCode;
    protected readonly string $baseCurrencyName;
    protected readonly string $currencyCode;
    protected readonly string $currencyName;
    protected readonly float $rateCross;
    protected readonly float $salePrice;
    protected readonly float $buyPrice;

    public function __construct(array $data)
    {
        $currency = $this->getCurrency($data);
        $baseCurrency = $this->getBaseCurrency($data);

        $this->currencyCode = $currency['alpha3'];
        $this->currencyName = $currency['name'];
        $this->baseCurrencyCode = $baseCurrency['alpha3'];
        $this->baseCurrencyName = $baseCurrency['name'];
        $this->rateCross = $this->determineRateCross($data);
        $this->salePrice = $this->pickSalePrice($data);
        $this->buyPrice = $this->pickBuyPrice($data);
    }

    abstract protected function getCurrency(array $data): array;

    abstract protected function getBaseCurrency(array $data): array;

    abstract protected function determineRateCross($data): float;

    abstract protected function pickSalePrice($data): float;

    abstract protected function pickBuyPrice($data): float;

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    public function getBaseCurrencyCode(): string
    {
        return $this->baseCurrencyCode;
    }

    public function getBaseCurrencyName(): string
    {
        return $this->baseCurrencyName;
    }

    public function getRateCross(): float
    {
        return $this->rateCross;
    }

    public function getSalePrice(): float
    {
        return $this->salePrice;
    }

    public function getBuyPrice(): float
    {
        return $this->buyPrice;
    }

    protected function calculateRateCross(float $salePrice): float
    {
        return round(1 / $salePrice, 4);
    }

    protected function getCurrencyByCode(int|string $code): array
    {
        return (new ISO4217())->getByCode(sprintf('%03d', $code));
    }

    protected function getCurrencyByAlpha3(string $alpha3): array
    {
        return (new ISO4217())->getByAlpha3($alpha3);
    }
}
