<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\proc;

use Rezident\WiseTelegramBot\proc\ProcCommand;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class ProcCommandTest extends TestCase
{
    private const CMD = 'command';

    private ProcCommand $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new ProcCommand(self::CMD);
    }

    public function testCommandLine(): void
    {
        $this->assertEquals([self::CMD], $this->command->getParts());
    }

    public function testCommandPartsWithSingleOption(): void
    {
        $this->assertEquals([self::CMD, '-h'], $this->command->addOption('-h')->getParts());
    }

    public function testCommandPartsWithOptionAndArgument(): void
    {
        $this->assertEquals(
            [self::CMD, '-h', 'option argument'],
            $this->command->addOption('-h', 'option argument')->getParts(),
        );
    }

    public function testBigCommandLine(): void
    {
        $this->assertEquals(
            [self::CMD, '-r', '-h', 'option argument', '-z', 'hello"', 'last argument'],
            $this->command
                ->addOption('-r')
                ->addOption('-h', 'option argument')
                ->addOption('-z', 'hello"')
                ->addOption('last argument')
                ->getParts(),
        );
    }

    public function testImmutability(): void
    {
        $withOneOption = $this->command->addOption('-h');
        $this->assertEquals([self::CMD, '-h'], $withOneOption->getParts());
        $this->assertEquals([self::CMD, '-h', '-a', 'hello'], $withOneOption->addOption('-a', 'hello')->getParts());
        $this->assertEquals([self::CMD, '-h'], $withOneOption->getParts());
    }
}
