<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\bot;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\bot\BotImplementation;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class BotImplementationTest extends TestCase
{
    public function testHandleUpdate(): void
    {
        $mock = $this->createMock(UpdateHandler::class);
        $mock->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(Update::class));

        $this->container->set(UpdateHandler::class, $mock);
        $bot = new BotImplementation($this->container);
        $bot->handleUpdate(['update_id' => 16]);
    }
}
