<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

class CommandIdExtractor
{
    public function extract(\ReflectionClass $reflection): string
    {
        $shortClassNameWithCutCommand = preg_replace('/Command$/', '', $reflection->getShortName());
        $command = preg_replace('/([A-Z])/', '_$1', $shortClassNameWithCutCommand);

        return strtolower(trim($command, '_'));
    }
}
