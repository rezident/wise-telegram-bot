<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\di;

use Rezident\WiseTelegramBot\di\exceptions\ClassNotFoundException;
use Rezident\WiseTelegramBot\di\exceptions\WrongInstanceException;

class Container
{
    private array $uniques = [];

    private array $instances = [];

    public function __construct()
    {
        $this->set(self::class, $this);
    }

    public function set(string $className, object $instance): void
    {
        if (!$instance instanceof $className) {
            throw new WrongInstanceException($className);
        }

        $this->instances[$className] = $instance;
    }

    /**
     * @psalm-template T
     *
     * @psalm-param class-string<T> $className
     *
     * @psalm-return T
     */
    public function get(string $className): object
    {
        if (!isset($this->instances[$className]) || isset($this->uniques[$className])) {
            $this->instances[$className] = $this->createInstance($className);
        }

        return $this->instances[$className];
    }

    public function alwaysUnique(string $className): void
    {
        $this->uniques[$className] = true;
    }

    private function createInstance(string $className): object
    {
        if (!class_exists($className)) {
            throw new ClassNotFoundException($className);
        }

        $reflection = new \ReflectionClass($className);

        $args = array_map(
            fn ($param) => $this->get($param->getType()->getName()),
            $reflection->getConstructor()?->getParameters() ?? [],
        );

        return $reflection->newInstanceArgs($args);
    }
}
