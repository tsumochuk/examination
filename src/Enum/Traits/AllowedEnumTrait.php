<?php

namespace App\Enum\Traits;

trait AllowedEnumTrait
{
    public static function allowedTypes(): array
    {
        return array_map(static fn(self $case) => $case->value, self::cases());
    }

    public static function isAllowed(string $case): bool
    {
        return true === in_array($case, self::allowedTypes(), true);
    }
}
