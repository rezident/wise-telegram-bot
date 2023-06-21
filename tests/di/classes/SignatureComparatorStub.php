<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di\classes;

class SignatureComparatorStub
{
    public function simple(): void
    {
    }

    public function withSingleArg(self $a): void
    {
    }

    public function withSingleNullableArg(?self $a): void
    {
    }

    public function withSingleArgAndReturn(self $a): int
    {
        return 0;
    }

    public function withDoubleArg(self $a, int $b): void
    {
    }

    public function withDoubleArgAndReturn(self $a, int $b): string
    {
        return '';
    }

    public function withDoubleArgAndNullableReturn(self $a, int $b): ?string
    {
        return '';
    }

    public function withDoubleArgAndUnionReturn(self $a, int $b): string|int
    {
        return 0;
    }

    public function withUnionArgAndUnionReturn(self|callable $a, int $b): string|int
    {
        return 0;
    }
}
