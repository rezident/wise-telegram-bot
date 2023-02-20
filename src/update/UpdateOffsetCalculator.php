<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;

class UpdateOffsetCalculator
{
    private ?int $offset = null;

    public function calculate(Update $update): void
    {
        $this->offset = $update->getUpdateId() + 1;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
