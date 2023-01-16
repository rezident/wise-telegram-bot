<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di;

use Rezident\WiseTelegramBot\di\exceptions\ClassNotFoundException;
use Rezident\WiseTelegramBot\di\exceptions\WrongInstanceException;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\di\classes\InjectableClass;
use Rezident\WiseTelegramBot\tests\di\classes\WithDependencyClass;

class ContainerTest extends TestCase
{
    public function testSetAndGetSame(): void
    {
        $instance = new InjectableClass();
        $this->container->set(InjectableClass::class, $instance);
        $this->assertSame($instance, $this->container->get(InjectableClass::class));
    }

    public function testThrowWrongInstanceException(): void
    {
        $this->expectException(WrongInstanceException::class);
        $this->container->set(self::class, new InjectableClass());
    }

    public function testCreateInstance(): void
    {
        $instance = $this->container->get(InjectableClass::class);
        $this->assertInstanceOf(InjectableClass::class, $instance);
    }

    public function testCreateSameInstance(): void
    {
        $instance = $this->container->get(InjectableClass::class);
        $this->assertSame($instance, $this->container->get(InjectableClass::class));
    }

    public function testCreateUniqueInstance(): void
    {
        $this->container->alwaysUnique(InjectableClass::class);
        $instance = $this->container->get(InjectableClass::class);
        $this->assertNotSame($instance, $this->container->get(InjectableClass::class));
    }

    public function testCreateInstanceWithDependency(): void
    {
        /** @var WithDependencyClass $instance */
        $instance = $this->container->get(WithDependencyClass::class);
        $this->assertInstanceOf(InjectableClass::class, $instance->getDependency());
    }

    public function testThrowClassNotFoundException(): void
    {
        $this->expectException(ClassNotFoundException::class);
        $this->container->get('bad class name');
    }
}
