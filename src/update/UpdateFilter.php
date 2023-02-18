<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;

class UpdateFilter
{
    private array $chatIdWhiteList = [];

    public function byChatId(int $chatId): static
    {
        $this->chatIdWhiteList[$chatId] = true;

        return $this;
    }

    public function filter(Update $update): ?Update
    {
        $chatId = $update->getMessage()->getChat()->getId();

        return 0 === \count($this->chatIdWhiteList) || isset($this->chatIdWhiteList[$chatId]) ? $update : null;
    }
}
