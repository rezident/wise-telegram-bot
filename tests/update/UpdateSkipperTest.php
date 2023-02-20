<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateSkipper;

class UpdateSkipperTest extends TestCase
{
    public function testSkip(): void
    {
        $this->registerMock(Executor::class)
            ->expects($this->once())
            ->method('execute')
            ->willReturn([include __DIR__ . '/stub/update.php'])
            ->with($this->isInstanceOf(GetUpdatesMethod::class));
        $this->registerMock(UpdateOffsetCalculator::class)
            ->expects($this->once())
            ->method('calculate')
            ->with($this->isInstanceOf(Update::class));

        $this->container->get(UpdateSkipper::class)->skip();
    }
}
