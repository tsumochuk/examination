<?php

namespace App\Enum;

use App\Enum\Interfaces\AllowedEnumInterface;
use App\Enum\Traits\AllowedEnumTrait;

enum BankTypeEnum: string implements AllowedEnumInterface
{
    use AllowedEnumTrait;

    case MONO_BANK = 'monobank';
    case PRIVAT_BANK = 'privat_bank';

    public function getLabel(): string
    {
        return match ($this) {
            self::MONO_BANK => 'MonoBank',
            self::PRIVAT_BANK => 'Privat Bank',
        };
    }
}
