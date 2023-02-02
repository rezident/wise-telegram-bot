<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\WiseTelegramBot\command\exceptions\CommandIdAlreadyExistException;

class CommandResolver
{
    private const DEFAULT_COMMAND_ID = '__default';

    /** @var CommandDefinition[] */
    private array $commands = [];

    public function __construct(
        private CommandIdCreator $commandIdCreator,
        private CommandDescriptionExtractor $commandDescriptionExtractor,
    ) {
    }

    public function resolve(string $commandId): ?CommandDefinition
    {
        return $this->commands[$commandId] ?? $this->commands[self::DEFAULT_COMMAND_ID] ?? null;
    }

    public function addCommands(array $classNames): void
    {
        array_map(fn ($className) => $this->addCommand($className), $classNames);
    }

    public function setDefaultCommand(string $className): void
    {
        $this->addCommand($className, self::DEFAULT_COMMAND_ID);
    }

    private function addCommand(string $className, ?string $forceId = null): void
    {
        try {
            $definition = new CommandDefinition(
                $className,
                $this->commandIdCreator,
                $this->commandDescriptionExtractor,
            );
        } catch (\Exception) {
            return;
        }

        $definitionId = $forceId ?? $definition->getId();
        if (isset($this->commands[$definitionId])) {
            throw new CommandIdAlreadyExistException($definitionId);
        }

        $this->commands[$definitionId] = $definition;
    }
}
