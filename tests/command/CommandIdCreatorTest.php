<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use PHPUnit\Framework\TestCase;
use Rezident\WiseTelegramBot\command\CommandIdCreator;

class CommandIdCreatorTest extends TestCase
{
    public function testCreate(): void
    {
        $creator = new CommandIdCreator();
        $this->assertEquals('first', $creator->create('FirstCommand'));
        $this->assertEquals('the_second', $creator->create('TheSecondCommand'));
        $this->assertEquals('the_third_one', $creator->create('TheThirdOne'));
    }
}
