<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\bot;

use Rezident\WiseTelegramBot\di\Container;

abstract class BotImplementation
{
    public function __construct(private Container $container)
    {
    }
}
