<?php

declare(strict_types=1);

namespace App\DTO\Currency;

use App\DTO\Currency\Type\CurrencyInterface;
use App\DTO\Currency\Type\MonoBankCurrency;
use App\DTO\Currency\Type\PrivatBankCurrency;
use App\Enum\BankTypeEnum;

final class Collection implements CollectionInterface
{
    private function __construct(
        private readonly array $store,
        private readonly BankTypeEnum $bank
    ) {}

    public static function fromMonoBankCurrencies(array $currencies): Collection
    {
        return new self(
            array_map(static fn($currency) => new MonoBankCurrency($currency), $currencies),
            BankTypeEnum::MONO_BANK
        );
    }

    public static function fromPrivatBankCurrencies(array $currencies): Collection
    {
        return new self(
            array_map(static fn($currency) => new PrivatBankCurrency($currency), $currencies),
            BankTypeEnum::PRIVAT_BANK
        );
    }

    /**
     * @return CurrencyInterface[]
     */
    public function getStore(): array
    {
        return $this->store;
    }

    public function getBank(): BankTypeEnum
    {
        return $this->bank;
    }

    public function filter(callable $filter, int $mode = 0): Collection
    {
        return new self(
            array_filter($this->store, $filter, $mode),
            $this->getBank()
        );
    }
}
