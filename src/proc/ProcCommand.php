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

    public function addArgument(string $argument): static
    {
        $quote = str_contains($argument, '"') ? "'" : '"';
        $this->parts[] = sprintf('%s%s%s', $quote, $argument, $quote);

        return $this;
    }

    public function addOption(string $option, ?string $argument = null): static
    {
        $this->parts[] = $option;
        if ($argument) {
            $this->addArgument($argument);
        }

        return $this;
    }

    public function getCommandLine(): string
    {
        return trim(implode(' ', $this->parts));
    }
}
