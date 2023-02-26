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
        $this->assertEquals(self::CMD, $this->command->getCommandLine());
    }

    public function testCommandLineWithArgument(): void
    {
        $this->assertEquals(
            sprintf('%s "argument"', self::CMD),
            $this->command->addArgument('argument')->getCommandLine(),
        );
    }

    public function testCommandLineWithRightQuoteArgument(): void
    {
        $this->assertEquals(
            sprintf('%s \'"argument"\'', self::CMD),
            $this->command->addArgument('"argument"')->getCommandLine(),
        );
    }

    public function testCommandLineWithSingleOption(): void
    {
        $this->assertEquals(sprintf('%s -h', self::CMD), $this->command->addOption('-h')->getCommandLine());
    }

    public function testCommandLineWithOptionAndArgument(): void
    {
        $this->assertEquals(
            sprintf('%s -h "option argument"', self::CMD),
            $this->command->addOption('-h', 'option argument')->getCommandLine(),
        );
    }

    public function testBigCommandLine(): void
    {
        $this->assertEquals(
            sprintf('%s -r -h "option argument" -z \'hello"\' "last argument"', self::CMD),
            $this->command
                ->addOption('-r')
                ->addOption('-h', 'option argument')
                ->addOption('-z', 'hello"')
                ->addArgument('last argument')
                ->getCommandLine(),
        );
    }
}
