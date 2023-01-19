<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use Rezident\WiseTelegramBot\command\CommandDefinition;
use Rezident\WiseTelegramBot\command\CommandDescriptionExtractor;
use Rezident\WiseTelegramBot\command\CommandIdCreator;
use Rezident\WiseTelegramBot\command\exceptions\ClassNotFoundException;
use Rezident\WiseTelegramBot\command\exceptions\UnimplementedInterfaceException;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;

class CommandDefinitionTest extends TestCase
{
    public function testThrowClassNotFoundException(): void
    {
        $this->expectException(ClassNotFoundException::class);
        new CommandDefinition('not className', new CommandIdCreator(), new CommandDescriptionExtractor());
    }

    public function testThrowUnimplementedInterfaceException(): void
    {
        $this->expectException(UnimplementedInterfaceException::class);
        new CommandDefinition(self::class, new CommandIdCreator(), new CommandDescriptionExtractor());
    }

    public function testGetId(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, new CommandIdCreator(), new CommandDescriptionExtractor());
        $this->assertEquals('the_second', $definition->getId());
    }

    public function testGetDescription(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, new CommandIdCreator(), new CommandDescriptionExtractor());
        $this->assertEquals('The first line of description', $definition->getDescription());
    }

    public function testGetClassName(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, new CommandIdCreator(), new CommandDescriptionExtractor());
        $this->assertEquals(TheSecondCommand::class, $definition->getClassName());
    }
}
