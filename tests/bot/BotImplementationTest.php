<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\bot;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\bot\BotImplementation;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateHandler;
use Rezident\WiseTelegramBot\update\UpdateSkipper;
use Rezident\WiseTelegramBot\update\UpdatesWatcher;

class BotImplementationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->registerMock(Executor::class);
    }

    public function testHandleUpdate(): void
    {
        $this->registerMock(UpdateHandler::class)
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(Update::class));

        $this->container->get(BotImplementation::class)->handleUpdate(['update_id' => 16]);
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

        $this->container->get(BotImplementation::class)->readCommands(__DIR__);
    }

    public function testSetDefaultCommand(): void
    {
        $this->registerMock(CommandResolver::class)
            ->expects($this->once())
            ->method('setDefaultCommand')
            ->with(__CLASS__);

        $this->container->get(BotImplementation::class)->setDefaultCommand(__CLASS__);
    }

    public function testRun(): void
    {
        $this->registerMock(UpdateSkipper::class)
            ->expects($this->once())
            ->method('skip');
        $this->registerMock(UpdatesWatcher::class)
            ->expects($this->once())
            ->method('watch')
            ->with(null);

        $this->container->get(BotImplementation::class)->run();
    }
}
