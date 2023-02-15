<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\base;

class Random
{
    public static function int(): int
    {
        return random_int(1, 10_000_000);
    }

    public static function str(): string
    {
        return mb_substr(base64_encode(random_bytes(32)), 0, 32);
    }
}
