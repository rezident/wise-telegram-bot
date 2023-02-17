<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;
use Rezident\WiseTelegramBot\tests\update\UpdateOffsetCalculator;

class UpdateSkipper
{
    public function __construct(private Executor $executor, private UpdateOffsetCalculator $updateOffsetCalculator)
    {
    }

    public function skip(): void
    {
        $updates = GetUpdatesMethod::new()->exec($this->executor);
        foreach ($updates as $update) {
            $this->updateOffsetCalculator->calculate($update);
        }
    }
}
