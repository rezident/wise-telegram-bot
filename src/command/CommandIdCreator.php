<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

class CommandIdCreator
{
    public function create(string $shortClassName): string
    {
        $shortClassNameWithCutCommand = preg_replace('/Command$/', '', $shortClassName);
        $command = preg_replace('/([A-Z])/', '_$1', $shortClassNameWithCutCommand);

        return strtolower(trim($command, '_'));
    }
}
