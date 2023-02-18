<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\temp\commands;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\SendMessageMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandInterface;

class StartCommand implements CommandInterface
{
    public function __construct(private Executor $executor)
    {
    }

    public function handle(string $argument, Update $update): void
    {
        SendMessageMethod::new($update->getMessage()->getChat()->getId(), 'привет')->exec($this->executor);
    }
}
