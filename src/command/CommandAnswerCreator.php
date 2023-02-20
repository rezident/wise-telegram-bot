<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

use Rezident\SelfDocumentedTelegramBotSdk\methods\SendMessageMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;

class CommandAnswerCreator
{
    private const PARSE_MODE_MARKDOWN_V2 = 'MarkdownV2';

    public function create(Update $incomingUpdate, string|array|null $commandAnswer): ?SendMessageMethod
    {
        if (null === $commandAnswer) {
            return null;
        }

        $text = \is_array($commandAnswer) ?
            implode(\PHP_EOL, array_map('strval', $commandAnswer)) :
            $commandAnswer;

        $result = SendMessageMethod::new($incomingUpdate->getMessage()->getChat()->getId(), $text);

        return \is_array($commandAnswer) ? $result->parseMode(self::PARSE_MODE_MARKDOWN_V2) : $result;
    }
}
