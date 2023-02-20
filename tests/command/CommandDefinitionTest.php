<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use Rezident\WiseTelegramBot\command\CommandDefinition;
use Rezident\WiseTelegramBot\command\CommandDescriptionExtractor;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\command\exceptions\ClassNotFoundException;
use Rezident\WiseTelegramBot\command\exceptions\UnimplementedInterfaceException;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;

class CommandDefinitionTest extends TestCase
{
    private CommandIdExtractor $idExtractor;
    private CommandDescriptionExtractor $descriptionExtractor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idExtractor = $this->container->get(CommandIdExtractor::class);
        $this->descriptionExtractor = $this->container->get(CommandDescriptionExtractor::class);
    }

    public function testThrowClassNotFoundException(): void
    {
        $this->expectException(ClassNotFoundException::class);
        new CommandDefinition('not className', $this->idExtractor, $this->descriptionExtractor);
    }

    public function testThrowUnimplementedInterfaceException(): void
    {
        $this->expectException(UnimplementedInterfaceException::class);
        new CommandDefinition(self::class, $this->idExtractor, $this->descriptionExtractor);
    }

    public function testGetId(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, $this->idExtractor, $this->descriptionExtractor);
        $this->assertEquals('the_second', $definition->getId());
    }

    public function testGetDescription(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, $this->idExtractor, $this->descriptionExtractor);
        $this->assertEquals('The description of the_second command', $definition->getDescription());
    }

    public function testGetClassName(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, $this->idExtractor, $this->descriptionExtractor);
        $this->assertEquals(TheSecondCommand::class, $definition->getClassName());
    }

    public function testGetMethodName(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, $this->idExtractor, $this->descriptionExtractor);
        $this->assertEquals('handle', $definition->getMethodName());
    }

    public function testCloneOnSetMethodName(): void
    {
        $definition = new CommandDefinition(TheSecondCommand::class, $this->idExtractor, $this->descriptionExtractor);
        $new = $definition->setMethodName('newMethod');
        $this->assertEquals('handle', $definition->getMethodName());
        $this->assertEquals('newMethod', $new->getMethodName());
    }
}
