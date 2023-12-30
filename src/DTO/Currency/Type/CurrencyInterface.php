<?php

namespace App\DTO\Currency\Type;

interface CurrencyInterface
{
    public function getCurrencyCode(): string;

    public function getCurrencyName(): string;

    public function getBaseCurrencyCode(): string;

    public function getBaseCurrencyName(): string;

    public function getRateCross(): float;

    public function getSalePrice(): float;

    public function getBuyPrice(): float;
}
