<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\temp\commands;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandInterface;

class StartCommand implements CommandInterface
{
    public function handle(string $argument, Update $update): string|array|null
    {
        return 'Привет';
    }
}
