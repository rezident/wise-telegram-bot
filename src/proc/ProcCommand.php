<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\proc;

class ProcCommand
{
    private array $parts;

    public function __construct(string $command)
    {
        $this->parts = [$command];
    }

    public function addOption(string $option, ?string $argument = null): static
    {
        $newThis = clone $this;

        $newThis->parts[] = $option;
        if ($argument) {
            $newThis->parts[] = $argument;
        }

        return $newThis;
    }

    public function getParts(): array
    {
        return $this->parts;
    }
}
