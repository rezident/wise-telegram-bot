<?php

/** @noinspection PhpUnusedLocalVariableInspection */

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\Description;
use Rezident\WiseTelegramBot\command\exceptions\DescriptionValidationException;

class DescriptionTest extends TestCase
{
    private const DESCRIPTION = 'description';

    public function testCreateInstance(): void
    {
        $description = new Description(self::DESCRIPTION);
        $this->assertEquals(self::DESCRIPTION, $description->getDescription());
    }

    public function testThrowDescriptionValidationExceptionOnEmpty(): void
    {
        $this->expectException(DescriptionValidationException::class);
        new Description('');
    }

    public function testThrowDescriptionValidationExceptionOnTooBig(): void
    {
        $this->expectException(DescriptionValidationException::class);
        new Description(str_repeat('1', 257));
    }
}
