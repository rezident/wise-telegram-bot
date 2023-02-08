<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\WiseTelegramBot\command\exceptions\ClassNotFoundException;
use Rezident\WiseTelegramBot\command\exceptions\UnimplementedInterfaceException;

class CommandDefinition
{
    private string $id;

    private ?string $description;

    private string $methodName = 'handle';

    public function __construct(
        private string $className,
        CommandIdExtractor $commandIdExtractor,
        CommandDescriptionExtractor $commandDescriptionExtractor,
    ) {
        if (!class_exists($className)) {
            throw new ClassNotFoundException($className);
        }

        $reflection = new \ReflectionClass($className);
        if (!$reflection->implementsInterface(CommandInterface::class)) {
            throw new UnimplementedInterfaceException($className);
        }

        $this->id = $commandIdExtractor->extract($reflection);
        $this->description = $commandDescriptionExtractor->extract($reflection);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    public function setMethodName(string $methodName): static
    {
        $new = clone $this;
        $new->methodName = $methodName;

        return $new;
    }
}
