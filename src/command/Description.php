<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Description
{
    public function __construct(private string $description)
    {
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
