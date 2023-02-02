<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\bot;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\bot\BotImplementation;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class BotImplementationTest extends TestCase
{
    public function testHandleUpdate(): void
    {
        $this->registerMock(UpdateHandler::class)
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(Update::class));

        $bot = new BotImplementation($this->container);
        $bot->handleUpdate(['update_id' => 16]);
    }

    public function testReadCommands(): void
    {
        $classesList = ['a', 'b'];

        $this->registerMock(ClassNamesReader::class)
            ->expects($this->once())
            ->method('read')
            ->with(__DIR__)
            ->willReturn($classesList);

        $this->registerMock(CommandResolver::class)
            ->expects($this->once())
            ->method('addCommands')
            ->with($classesList);

        $bot = new BotImplementation($this->container);
        $bot->readCommands(__DIR__);
    }

    public function testSetDefaultCommand(): void
    {
        $this->registerMock(CommandResolver::class)
            ->expects($this->once())
            ->method('setDefaultCommand')
            ->with(__CLASS__);

        $bot = new BotImplementation($this->container);
        $bot->setDefaultCommand(__CLASS__);
    }
}
