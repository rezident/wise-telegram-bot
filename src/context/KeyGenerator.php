<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\context;

class KeyGenerator
{
    private const HASH_LENGTH = 16;

    public function __construct(private string $prefix)
    {
    }

    public function getKey(string $value): string
    {
        $prefixHash = substr(md5($this->prefix), self::HASH_LENGTH);
        $valueHash = substr(md5($value), self::HASH_LENGTH);

        return implode('-', [$prefixHash, $valueHash]);
    }
}
