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
        $this->parts[] = $option;
        if ($argument) {
            $this->parts[] = $argument;
        }

        return $this;
    }

    public function getParts(): array
    {
        return $this->parts;
    }
}
