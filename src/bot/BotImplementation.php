<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\bot;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\di\Container;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\update\UpdateHandler;
use Rezident\WiseTelegramBot\update\UpdateSkipper;
use Rezident\WiseTelegramBot\update\UpdatesWatcher;

class BotImplementation
{
    private UpdateHandler $updateHandler;
    private ClassNamesReader $classNamesReader;
    private CommandResolver $commandResolver;
    private UpdateSkipper $updateSkipper;
    private UpdatesWatcher $updatesWatcher;

    public function __construct(private Container $container)
    {
        $this->updateHandler = $this->container->get(UpdateHandler::class);
        $this->classNamesReader = $this->container->get(ClassNamesReader::class);
        $this->commandResolver = $this->container->get(CommandResolver::class);
        $this->updateSkipper = $this->container->get(UpdateSkipper::class);
        $this->updatesWatcher = $this->container->get(UpdatesWatcher::class);
    }

    public function handleUpdate(array $update): void
    {
        $this->updateHandler->handle(Update::fromArray($update));
    }

    public function readCommands(string $dirPath): void
    {
        $classNames = $this->classNamesReader->read($dirPath);
        $this->commandResolver->addCommands($classNames);
    }

    public function setDefaultCommand(string $className): void
    {
        $this->commandResolver->setDefaultCommand($className);
    }

    public function run(): void
    {
        $this->updateSkipper->skip();
        $this->updatesWatcher->watch();
    }
}
