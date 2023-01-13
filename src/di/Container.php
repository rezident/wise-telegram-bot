<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\di;

use Rezident\WiseTelegramBot\di\exceptions\NotInstanceOfException;

class Container
{
    private array $instances;

    public function set(string $className, object $instance): void
    {
        if (!$instance instanceof $className) {
            throw new NotInstanceOfException($className);
        }

        $this->instances[$className] = $instance;
    }

    public function get(string $className): object
    {
        return $this->instances[$className];
    }
}
