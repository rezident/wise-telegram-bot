<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

class CommandDescriptionExtractor
{
    public function extract(string|bool $docComment): ?string
    {
        if (false === $docComment) {
            return null;
        }

        preg_match('/^ \* (.+)$/mu', $docComment, $matches);

        if (2 !== \count($matches)) {
            return null;
        }

        return trim(trim($matches[1]), '.');
    }
}
