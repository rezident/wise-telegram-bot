<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di\classes;

class WithDependencyClass
{
    public function __construct(private InjectableClass $dependency)
    {
    }

    public function getDependency(): InjectableClass
    {
        return $this->dependency;
    }
}
