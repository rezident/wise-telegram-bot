<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\tests\command\stub\CustomCommandId;
use Rezident\WiseTelegramBot\tests\command\stub\FirstCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;

class CommandIdExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $extractor = new CommandIdExtractor();
        $this->assertEquals('first', $extractor->extract(new \ReflectionClass(FirstCommand::class)));
        $this->assertEquals('the_second', $extractor->extract(new \ReflectionClass(TheSecondCommand::class)));
        $this->assertEquals('the_third_one', $extractor->extract(new \ReflectionClass(TheThirdOneCommand::class)));
    }

    public function testExtractFromAttribute(): void
    {
        $extractor = new CommandIdExtractor();
        $this->assertEquals('custom_id', $extractor->extract(new \ReflectionClass(CustomCommandId::class)));
    }
}
