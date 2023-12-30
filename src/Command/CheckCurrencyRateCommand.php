<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\BankTypeEnum;
use App\Enum\ChannelTypeEnum;
use App\Enum\FormatTypeEnum;
use App\Service\Currency\CurrencyWorkerServiceFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:check-currency-rate',
    description: 'Check currency rates and notify if they change beyond the threshold',
)]
final class CheckCurrencyRateCommand extends Command
{
    public function __construct(
        private readonly CurrencyWorkerServiceFactory $factory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'threshold',
            InputArgument::REQUIRED,
            'Threshold value must be passed as coins'
        );

        $this->addArgument(
            'bank',
            InputArgument::REQUIRED,
            sprintf('Bank name for check (%s)', implode(', ', BankTypeEnum::allowedTypes())),
        );

        $this->addArgument(
            'channel',
            InputArgument::OPTIONAL,
            sprintf('Enter the channel type for notification (%s)', implode(', ', ChannelTypeEnum::allowedTypes())),
            ChannelTypeEnum::TELEGRAM->value
        );

        $this->addArgument(
            'format',
            InputArgument::OPTIONAL,
            sprintf('Enter the channel type for notification (%s)', implode(', ', FormatTypeEnum::allowedTypes())),
            FormatTypeEnum::TEXT->value
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        [$threshold, $bank, $channel, $format] = $this->getArguments($input);

        $this->factory->createCurrencyCheckService($bank, $channel, $format)->checkCurrencyRate($threshold);

        return Command::SUCCESS;
    }

    private function getArguments(InputInterface $input): array
    {
        $threshold = $input->getArgument('threshold');
        $bank = $input->getArgument('bank');
        $channel = $input->getArgument('channel');
        $format = $input->getArgument('format');

        if (0 === preg_match('/^\d+$/', $threshold)) {
            throw new InvalidArgumentException(
                "Threshold parameter value is not valid: '$threshold'. It must be passed as integer value (coins)"
            );
        }

        $bank = BankTypeEnum::tryFrom($bank) ?: throw new InvalidArgumentException("Not supported bank type: $bank");
        $channel = ChannelTypeEnum::tryFrom($channel) ?: throw new InvalidArgumentException("Not supported channel type: $channel");
        $format = FormatTypeEnum::tryFrom($format) ?: throw new InvalidArgumentException("Not supported format type: $format");

        return [(int) $threshold, $bank, $channel, $format];
    }
}
