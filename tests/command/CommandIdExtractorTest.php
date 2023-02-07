<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\tests\command\stub\FirstCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;

class CommandIdExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $creator = new CommandIdExtractor();
        $this->assertEquals('first', $creator->extract(new \ReflectionClass(FirstCommand::class)));
        $this->assertEquals('the_second', $creator->extract(new \ReflectionClass(TheSecondCommand::class)));
        $this->assertEquals('the_third_one', $creator->extract(new \ReflectionClass(TheThirdOneCommand::class)));
    }
}
