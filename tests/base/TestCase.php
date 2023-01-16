<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\base;

use Rezident\WiseTelegramBot\di\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }
}
