<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\proc\exceptions;

use Rezident\WiseTelegramBot\base\Exception;

class WrongArraySizeException extends Exception
{
    public function __construct(int $actualSize)
    {
        parent::__construct(sprintf('%s is the wrong size of the array', $actualSize));
    }
}
