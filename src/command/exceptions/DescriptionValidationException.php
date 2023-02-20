<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command\exceptions;

use Rezident\WiseTelegramBot\base\Exception;

class DescriptionValidationException extends Exception
{
    public function __construct(string $message = '1-256 characters', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
