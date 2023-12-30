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

final class PrivatBankService implements BankCurrenciesInterface
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
            ->request('GET', 'https://api.privatbank.ua/p24api/pubinfo')
            ->toArray();

        return Collection::fromPrivatBankCurrencies($items);
    }
}
