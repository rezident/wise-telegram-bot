<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\command\exceptions\CommandIdAlreadyExistException;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\FirstCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;

class CommandResolverTest extends TestCase
{
    private CommandResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = $this->container->get(CommandResolver::class);
    }

    public function testResolveReturnNull(): void
    {
        $this->assertNull($this->resolver->resolve('not exist'));
    }

    public function testResolveCommands(): void
    {
        $classNames = $this->container->get(ClassNamesReader::class)->read(__DIR__ . '/../command/stub');
        $this->resolver->addCommands($classNames);
        $command = $this->resolver->resolve('first');
        $this->assertNotNull($command);
        $this->assertEquals(FirstCommand::class, $command->getClassName());
        $command = $this->resolver->resolve('the_second');
        $this->assertNotNull($command);
        $this->assertEquals(TheSecondCommand::class, $command->getClassName());
    }

    public function testDontResolveNotCommand(): void
    {
        $classNames = $this->container->get(ClassNamesReader::class)->read(__DIR__ . '/../command/stub');
        $this->resolver->addCommands($classNames);
        $this->assertNull($this->resolver->resolve('not'));
    }

    public function testResolveDefaultCommand(): void
    {
        $this->resolver->addDefaultCommand(FirstCommand::class);
        $command = $this->resolver->resolve('random string');
        $this->assertNotNull($command);
        $this->assertEquals(FirstCommand::class, $command->getClassName());
    }

    public function testThrowCommandIdAlreadyExist(): void
    {
        $this->expectException(CommandIdAlreadyExistException::class);
        $this->resolver->addCommands([FirstCommand::class]);
        $this->resolver->addCommands([FirstCommand::class]);
    }
}
