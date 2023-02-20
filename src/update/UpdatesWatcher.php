<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;

class UpdatesWatcher
{
    private const TIMEOUT = 30;

    public function __construct(
        private Executor $executor,
        private UpdateHandler $updateHandler,
        private UpdateOffsetCalculator $updateOffsetCalculator,
    ) {
    }

    public function watch(?int $requestsLimit = null): void
    {
        while (null === $requestsLimit || $requestsLimit--) {
            $updates = GetUpdatesMethod::new()
                ->offset($this->updateOffsetCalculator->getOffset())
                ->timeout(self::TIMEOUT)
                ->exec($this->executor);
            foreach ($updates as $update) {
                $this->updateHandler->handle($update);
                $this->updateOffsetCalculator->calculate($update);
            }
        }
    }
}
