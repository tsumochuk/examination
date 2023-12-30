<?php

declare(strict_types=1);

namespace App\Service\Currency;

use App\Enum\BankTypeEnum;
use App\Enum\ChannelTypeEnum;
use App\Enum\FormatTypeEnum;
use App\Service\Currency\BankService\Interfaces\BankCurrenciesInterface;
use App\Service\Currency\BankService\MonoBankService;
use App\Service\Currency\BankService\PrivatBankService;
use App\Service\Currency\Formatters\FormatterInterface;
use App\Service\Currency\Formatters\PlainTextFormatter;
use App\Service\NotifyService\NotifierInterface;
use App\Service\NotifyService\TelegramNotifier;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class CurrencyWorkerServiceFactory
{
    public function __construct(private readonly ContainerInterface $container) {}

    public function createCurrencyCheckService(BankTypeEnum $bank, ChannelTypeEnum $channel, FormatTypeEnum $format): CurrencyWorker
    {
        return new CurrencyWorker(
            $this->getBankService($bank),
            $this->getNotifier($channel),
            $this->getFormatter($format),
        );
    }

    private function getBankService(BankTypeEnum $bank): BankCurrenciesInterface
    {
        return match ($bank) {
            BankTypeEnum::MONO_BANK => $this->container->get(MonoBankService::class),
            BankTypeEnum::PRIVAT_BANK => $this->container->get(PrivatBankService::class),
        };
    }

    private function getNotifier(ChannelTypeEnum $channel): NotifierInterface
    {
        return match ($channel) {
            ChannelTypeEnum::TELEGRAM => $this->container->get(TelegramNotifier::class),
        };
    }

    private function getFormatter(FormatTypeEnum $format): FormatterInterface
    {
        return match ($format) {
            FormatTypeEnum::TEXT => $this->container->get(PlainTextFormatter::class),
        };
    }
}
