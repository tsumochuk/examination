<?php

namespace App\Enum;

use App\Enum\Interfaces\AllowedEnumInterface;
use App\Enum\Traits\AllowedEnumTrait;

enum FormatTypeEnum: string implements AllowedEnumInterface
{
    use AllowedEnumTrait;

    case TEXT = 'text';
}
