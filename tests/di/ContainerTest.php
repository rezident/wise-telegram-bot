<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\WiseTelegramBot\di\Container;
use Rezident\WiseTelegramBot\di\exceptions\NotInstanceOfException;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testSetAndGetSame(): void
    {
        $instance = new Executor('');
        $this->container->set(Executor::class, $instance);
        $this->assertSame($instance, $this->container->get(Executor::class));
    }

    public function testThrowNotInstanceOfException(): void
    {
        $this->expectException(NotInstanceOfException::class);
        $this->container->set(self::class, new Executor(''));
    }
}
