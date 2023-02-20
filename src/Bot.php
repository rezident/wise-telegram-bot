<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot;

use Rezident\WiseTelegramBot\bot\BotImplementation;
use Rezident\WiseTelegramBot\di\BotContainerFactory;

class Bot extends BotImplementation
{
    public function __construct(string $token)
    {
        parent::__construct(BotContainerFactory::getContainer($token));
    }
}
