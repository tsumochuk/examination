<?php

namespace App\Enum\Interfaces;

interface AllowedEnumInterface
{
    public static function allowedTypes(): array;

    public static function isAllowed(string $case): bool;
}
