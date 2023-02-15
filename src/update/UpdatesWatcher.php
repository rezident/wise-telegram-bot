<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;

class UpdatesWatcher
{
    public function __construct(private Executor $executor, private UpdateHandler $updateHandler)
    {
    }

    public function watch(?int $requestsLimit = null): void
    {
        while (null === $requestsLimit || $requestsLimit--) {
            $updates = GetUpdatesMethod::new()->exec($this->executor);
            foreach ($updates as $update) {
                $this->updateHandler->handle($update);
            }
        }
    }
}
