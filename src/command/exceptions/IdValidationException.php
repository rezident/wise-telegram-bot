<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command\exceptions;

use Rezident\WiseTelegramBot\base\Exception;

class IdValidationException extends Exception
{
    public function __construct(
        string $message = '1-32 characters. Can contain only lowercase English letters, digits and underscores',
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
