<?php

declare(strict_types=1);

namespace App\Service\Currency\BankService;

use App\DTO\Currency\Collection;
use App\Service\Currency\BankService\Interfaces\BankCurrenciesInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class MonoBankService implements BankCurrenciesInterface
{
    /**
     * @return Collection
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fetchAllCurrencies(): Collection
    {
        $items = (new RetryableHttpClient(HttpClient::create(), maxRetries: 10))
            ->request('GET', 'https://api.monobank.ua/bank/currency')
            ->toArray();

        // filtering items, because most of them have cross rate and do not have buy/sell price,
        // and I'm not sure if it's appropriate to do different price calculations
        return Collection::fromMonoBankCurrencies($this->filter($items));
    }

    private function filter(array $items): array
    {
        return array_values(
            array_filter(
                $items,
                static fn($item) => true === isset($item['rateBuy'], $item['rateSell'])
            )
        );
    }
}
