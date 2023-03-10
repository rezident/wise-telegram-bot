<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\CommandDescriptionExtractor;
use Rezident\WiseTelegramBot\tests\command\stub\FirstCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;

class CommandDescriptionExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $extractor = new CommandDescriptionExtractor();
        $this->assertEquals(
            'The description of the_second command',
            $extractor->extract(new \ReflectionClass(TheSecondCommand::class)),
        );
    }

    public function testExtractNull(): void
    {
        $extractor = new CommandDescriptionExtractor();
        $this->assertNull($extractor->extract(new \ReflectionClass(FirstCommand::class)));
    }
}
