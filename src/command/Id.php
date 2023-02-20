<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\WiseTelegramBot\command\exceptions\IdValidationException;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Id
{
    public function __construct(private string $id)
    {
        if (0 === preg_match('/^[a-z0-9_]{1,32}$/', $id)) {
            throw new IdValidationException();
        }
    }

    public function getId(): string
    {
        return $this->id;
    }
}
