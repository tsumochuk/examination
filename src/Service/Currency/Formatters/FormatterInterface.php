<?php

namespace App\Service\Currency\Formatters;

use App\DTO\Currency\Collection;

interface FormatterInterface
{
    public function getMessage(Collection $collection): string;
}
