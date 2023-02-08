<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandDefinition;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\di\Container;

class UpdateHandler
{
    public function __construct(private CommandResolver $commandResolver, private Container $container)
    {
    }

    public function handle(Update $update): void
    {
        $commandDefinition = $this->getCommandDefinition($update);
        if (!$commandDefinition) {
            return;
        }
        $command = $this->container->get($commandDefinition->getClassName());
        $callable = [$command, $commandDefinition->getMethodName()];
        \call_user_func($callable, $this->getArgument($update), $update);
    }

    private function getCommandId(string $messageText): ?string
    {
        $messageParts = explode(' ', $messageText);
        $firstWord = array_shift($messageParts);

        return 1 === preg_match('/^\/[a-z0-9_]+$/', $firstWord) ? mb_substr($firstWord, 1) : null;
    }

    private function getArgument(Update $update): string
    {
        return preg_replace('/^\/[a-z0-9_]+ */', '', $update->getMessage()->getText());
    }

    private function getCommandDefinition(Update $update): ?CommandDefinition
    {
        $messageText = $update->getMessage()->getText();
        if (empty($messageText)) {
            return null;
        }

        $commandId = $this->getCommandId($messageText);

        return $commandId ?
            $this->commandResolver->resolve($commandId) :
            $this->commandResolver->getDefaultCommand();
    }
}
