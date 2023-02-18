<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\bot;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\di\Container;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\update\UpdateFilter;
use Rezident\WiseTelegramBot\update\UpdateHandler;
use Rezident\WiseTelegramBot\update\UpdateSkipper;
use Rezident\WiseTelegramBot\update\UpdatesWatcher;

class BotImplementation
{
    private ClassNamesReader $classNamesReader;
    private CommandResolver $commandResolver;
    private UpdateFilter $updateFilter;
    private UpdateHandler $updateHandler;
    private UpdateSkipper $updateSkipper;
    private UpdatesWatcher $updatesWatcher;

    public function __construct(private Container $container)
    {
        $this->classNamesReader = $this->container->get(ClassNamesReader::class);
        $this->commandResolver = $this->container->get(CommandResolver::class);
        $this->updateFilter = $this->container->get(UpdateFilter::class);
        $this->updateHandler = $this->container->get(UpdateHandler::class);
        $this->updateSkipper = $this->container->get(UpdateSkipper::class);
        $this->updatesWatcher = $this->container->get(UpdatesWatcher::class);
    }

    public function handleUpdate(array $update): void
    {
        $this->updateHandler->handle(Update::fromArray($update));
    }

    public function readCommands(string $dirPath): static
    {
        $classNames = $this->classNamesReader->read($dirPath);
        $this->commandResolver->addCommands($classNames);

        return $this;
    }

    public function setDefaultCommand(string $className): static
    {
        $this->commandResolver->setDefaultCommand($className);

        return $this;
    }

    public function acceptOnly(int $chatId): static
    {
        $this->updateFilter->byChatId($chatId);

        return $this;
    }

    public function run(): void
    {
        $this->updateSkipper->skip();
        $this->updatesWatcher->watch();
    }
}
