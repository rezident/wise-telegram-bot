<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\di;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\update\UpdateFilter;
use Rezident\WiseTelegramBot\update\UpdateOffsetCalculator;

class BotContainerFactory
{
    public static function getContainer(string $botToken): Container
    {
        return (new Container())
            ->withSingleton(UpdateOffsetCalculator::class)
            ->withSingleton(UpdateFilter::class)
            ->withSingleton(CommandResolver::class)
            ->set(Executor::class, new Executor($botToken));
    }
}
