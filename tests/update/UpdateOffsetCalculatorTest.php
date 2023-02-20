<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateOffsetCalculator;

class UpdateOffsetCalculatorTest extends TestCase
{
    public function testNullOffset(): void
    {
        $this->assertNull($this->container->get(UpdateOffsetCalculator::class)->getOffset());
    }

    public function testNextOffset(): void
    {
        $calculator = $this->container->get(UpdateOffsetCalculator::class);
        $update = Update::fromArray(include __DIR__ . '/stub/update.php');
        $calculator->calculate($update);
        $this->assertEquals($update->getUpdateId() + 1, $calculator->getOffset());
    }
}
