<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command\stub;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandInterface;
use Rezident\WiseTelegramBot\command\Id;

#[Id('custom_id')]
class CustomCommandId implements CommandInterface
{
    public function handle(string $argument, Update $update): string|array|null
    {
        return null;
    }
}
