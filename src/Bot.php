<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\WiseTelegramBot\bot\BotImplementation;
use Rezident\WiseTelegramBot\di\Container;

class Bot extends BotImplementation
{
    public function __construct(string $token)
    {
        $conatiner = new Container();
        $conatiner->set(Executor::class, new Executor($token));
        parent::__construct($conatiner);
    }
}
