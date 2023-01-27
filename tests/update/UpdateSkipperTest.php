<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateSkipper;

class UpdateSkipperTest extends TestCase
{
    public function testSkip(): void
    {
        $mock = $this->createMock(Executor::class);
        $mock->expects($this->once())
            ->method('execute')
            ->willReturn([])
            ->with($this->isInstanceOf(GetUpdatesMethod::class));

        $skipper = new UpdateSkipper($mock);
        $skipper->skip();
    }
}
