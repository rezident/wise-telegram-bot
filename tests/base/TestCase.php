<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\base;

use PHPUnit\Framework\MockObject\MockObject;
use Rezident\WiseTelegramBot\di\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    /**
     * @psalm-template RealInstanceType of object
     *
     * @psalm-param class-string<RealInstanceType> $className
     *
     * @psalm-return MockObject&RealInstanceType
     */
    protected function registerMock(string $className): MockObject
    {
        $mock = $this->createMock($className);
        $this->container->set($className, $mock);
        $this->container->set($mock::class, $mock);

        return $mock;
    }
}
