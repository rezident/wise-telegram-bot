<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\WiseTelegramBot\command\exceptions\DescriptionValidationException;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Description
{
    public function __construct(private string $description)
    {
        if (1 > mb_strlen($description) || mb_strlen($description) > 256) {
            throw new DescriptionValidationException();
        }
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
