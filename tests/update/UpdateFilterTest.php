<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateFilter;

class UpdateFilterTest extends TestCase
{
    private Update $update;

    protected function setUp(): void
    {
        parent::setUp();
        $this->update = Update::fromArray(include __DIR__ . '/stub/update.php');
    }

    public function testReturnSameUpdate(): void
    {
        $this->assertSame($this->update, $this->container->get(UpdateFilter::class)->filter($this->update));
    }

    public function testReturnNullByChatId(): void
    {
        $filter = $this->container->get(UpdateFilter::class);
        $filter->byChatId($this->update->getMessage()->getChat()->getId() + 1);

        $this->assertNull($filter->filter($this->update));
    }

    public function testReturnFilteredByChatIdUpdate(): void
    {
        $filter = $this->container->get(UpdateFilter::class);
        $filter->byChatId($this->update->getMessage()->getChat()->getId());

        $this->assertSame($this->update, $filter->filter($this->update));
    }
}
