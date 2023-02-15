<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateHandler;
use Rezident\WiseTelegramBot\update\UpdatesWatcher;

class UpdatesWatcherTest extends TestCase
{
    private const CALL_COUNT = 5;

    public function testWatchWithUpdate(): void
    {
        $updates = [include __DIR__ . '/stub/update.php'];
        $this->registerWatcherMocks($updates, self::CALL_COUNT);
        $this->container->get(UpdatesWatcher::class)->watch(self::CALL_COUNT);
    }

    public function testWatchWithoutUpdate(): void
    {
        $this->registerWatcherMocks([], 0);
        $this->container->get(UpdatesWatcher::class)->watch(self::CALL_COUNT);
    }

    private function registerWatcherMocks(array $updates, int $handlerCalls): void
    {
        $this->registerMock(Executor::class)
            ->expects($this->exactly(self::CALL_COUNT))
            ->method('execute')
            ->willReturn($updates);
        $this->registerMock(UpdateHandler::class)
            ->expects($this->exactly($handlerCalls))
            ->method('handle')
            ->with($this->isInstanceOf(Update::class));
    }
}
