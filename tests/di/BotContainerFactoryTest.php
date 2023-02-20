<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\di\BotContainerFactory;
use Rezident\WiseTelegramBot\di\Container;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\update\UpdateFilter;
use Rezident\WiseTelegramBot\update\UpdateOffsetCalculator;

class BotContainerFactoryTest extends TestCase
{
    public function testGetSameContainer(): void
    {
        $container = BotContainerFactory::getContainer('');
        $this->assertSame($container->get(Container::class), $container->get(Container::class));
    }

    public function testGetSameUpdateOffsetCalculator(): void
    {
        $container = BotContainerFactory::getContainer('');
        $this->assertSame(
            $container->get(UpdateOffsetCalculator::class),
            $container->get(UpdateOffsetCalculator::class),
        );
    }

    public function testGetSameCommandResolver(): void
    {
        $container = BotContainerFactory::getContainer('');
        $this->assertSame($container->get(CommandResolver::class), $container->get(CommandResolver::class));
    }

    public function testGetSameExecutor(): void
    {
        $container = BotContainerFactory::getContainer('');
        $this->assertSame($container->get(Executor::class), $container->get(Executor::class));
    }

    public function testGetSameUpdateFilter(): void
    {
        $container = BotContainerFactory::getContainer('');
        $this->assertSame($container->get(UpdateFilter::class), $container->get(UpdateFilter::class));
    }
}
