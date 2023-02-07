<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command\stub;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandInterface;

class TheThirdOneCommand implements CommandInterface
{
    public function handle(string $argument, Update $update): void
    {
    }
}
