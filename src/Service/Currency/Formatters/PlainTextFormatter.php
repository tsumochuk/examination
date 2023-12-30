<?php

declare(strict_types=1);

namespace App\Service\Currency\Formatters;

use App\DTO\Currency\Collection;
use App\DTO\Currency\Type\CurrencyInterface;

final class PlainTextFormatter implements FormatterInterface
{
    private const INDENTATION_SIZE = 2;

    public function getMessage(Collection $collection): string
    {
        $messages = [
            sprintf('Currencies from %s', $collection->getBank()->getLabel())
        ];

        foreach ($collection->getStore() as $item) {
            $messages[] = implode(PHP_EOL, [
                $this->getBuySaleLine($item),
                $this->getCrossRateLine($item),
            ]);
        }

        if (true === empty($messages)) {
            $messages[] = 'There are no fresh information';
        }

        return implode($this->getIndentation(), $messages);
    }

    private function getBuySaleLine(CurrencyInterface $currency): string
    {
        return vsprintf('%s (%s): %s / %s', [
            $currency->getCurrencyName(),
            $currency->getCurrencyCode(),
            $this->normalizePrice($currency->getBuyPrice()),
            $this->normalizePrice($currency->getSalePrice()),
        ]);
    }

    private function getCrossRateLine(CurrencyInterface $currency): string
    {
        return vsprintf('Cross Rate %s/%s = %f', [
            $currency->getBaseCurrencyCode(),
            $currency->getCurrencyCode(),
            $currency->getRateCross()
        ]);
    }

    private function normalizePrice(float $price): float
    {
        return (float) number_format($price, 2, '.', '');
    }

    private function getIndentation(): string
    {
        return str_repeat(PHP_EOL, static::INDENTATION_SIZE);
    }
}
