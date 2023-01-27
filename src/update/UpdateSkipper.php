<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\GettingUpdates\GetUpdatesMethod;

class UpdateSkipper
{
    public function __construct(private Executor $executor)
    {
    }

    public function skip(): void
    {
        GetUpdatesMethod::new()->exec($this->executor);
    }
}
