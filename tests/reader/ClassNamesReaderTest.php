<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\reader;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\reader\ClassNameExtractor;
use Rezident\WiseTelegramBot\reader\ClassNamesReader;
use Rezident\WiseTelegramBot\tests\command\stub\FirstCommand;
use Rezident\WiseTelegramBot\tests\command\stub\NotCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;

class ClassNamesReaderTest extends TestCase
{
    public function testRead(): void
    {
        $reader = new ClassNamesReader(new ClassNameExtractor());
        $classNames = $reader->read(__DIR__ . '/../command/stub');

        $this->assertCount(4, $classNames);
        $this->assertContains(FirstCommand::class, $classNames);
        $this->assertContains(TheSecondCommand::class, $classNames);
        $this->assertContains(NotCommand::class, $classNames);
        $this->assertContains(TheThirdOneCommand::class, $classNames);
    }
}
