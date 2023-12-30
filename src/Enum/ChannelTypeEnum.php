<?php

namespace App\Enum;

use App\Enum\Interfaces\AllowedEnumInterface;
use App\Enum\Traits\AllowedEnumTrait;

enum ChannelTypeEnum: string implements AllowedEnumInterface
{
    use AllowedEnumTrait;

    case TELEGRAM = 'telegram';
}
