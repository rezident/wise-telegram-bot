<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\SelfDocumentedTelegramBotSdk\methods\SendMessageMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;

class CommandAnswerCreator
{
    public function create(Update $incomingUpdate, string|array|null $commandAnswer): ?SendMessageMethod
    {
        if (null === $commandAnswer) {
            return null;
        }

        $text = \is_array($commandAnswer) ?
            implode(\PHP_EOL, array_map('strval', $commandAnswer)) :
            $commandAnswer;

        return SendMessageMethod::new($incomingUpdate->getMessage()->getChat()->getId(), $text)
            ->parseMode('MarkdownV2');
    }
}
