<?php

declare(strict_types=1);

namespace App\Service\Currency;

use App\DTO\Currency\Type\CurrencyInterface;
use App\Service\Currency\BankService\Interfaces\BankCurrenciesInterface;
use App\Service\Currency\Formatters\FormatterInterface;
use App\Service\NotifyService\NotifierInterface;

final class CurrencyWorker
{
    public function __construct(
        private readonly BankCurrenciesInterface $bank,
        private readonly NotifierInterface $notifier,
        private readonly FormatterInterface $formatter,
    ) {}

    public function checkCurrencyRate(int $difference): void
    {
        $currencies = $this->bank->fetchAllCurrencies();

        $filter = static fn(CurrencyInterface $i) => (abs($i->getSalePrice() - $i->getBuyPrice()) * 100) > $difference;

        $this->notifier->notify(
            $this->formatter->getMessage($currencies->filter($filter))
        );
    }
}
