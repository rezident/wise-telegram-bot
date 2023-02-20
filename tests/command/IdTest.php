<?php

/** @noinspection PhpExpressionResultUnusedInspection */

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\exceptions\IdValidationException;
use Rezident\WiseTelegramBot\command\Id;

class IdTest extends TestCase
{
    private const ID = 'good_id5';

    public function testCreateInstance(): void
    {
        $id = new Id(self::ID);
        $this->assertEquals(self::ID, $id->getId());
    }

    public function testThrowIdValidationExceptionOnShortId(): void
    {
        $this->expectException(IdValidationException::class);
        new Id('');
    }

    public function testThrowIdValidationExceptionOnLongId(): void
    {
        $this->expectException(IdValidationException::class);
        new Id(str_repeat('1', 33));
    }

    public function testThrowIdValidationExceptionOnBigLetters(): void
    {
        $this->expectException(IdValidationException::class);
        new Id('Big');
    }

    public function testThrowIdValidationExceptionOnExtraLetters(): void
    {
        $this->expectException(IdValidationException::class);
        new Id('big-ban');
    }
}
