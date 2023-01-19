<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;

interface CommandInterface
{
    public function handle(string $argument, Update $update);
}
