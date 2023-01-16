<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\bot;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\di\Container;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class BotImplementation
{
    private UpdateHandler $updateHandler;

    public function __construct(private Container $container)
    {
        $this->updateHandler = $this->container->get(UpdateHandler::class);
    }

    public function handleUpdate(array $update): void
    {
        $this->updateHandler->handle(Update::fromArray($update));
    }
}
