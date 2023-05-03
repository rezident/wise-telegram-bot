<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\proc;

use Rezident\WiseTelegramBot\proc\exceptions\ArrayItemsIsNotResourcesException;
use Rezident\WiseTelegramBot\proc\exceptions\WrongArraySizeException;

class Pipes
{
    public const DESCRIPTOR = [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']];

    private const OUT = 1;
    private const ERR = 2;

    /**
     * @var resource[]
     */
    private array $pipes;

    public function __construct(array $pipes)
    {
        if (\count(static::DESCRIPTOR) !== \count($pipes)) {
            throw new WrongArraySizeException(\count($pipes));
        }

        if (\count(array_filter($pipes, fn ($pipe) => !\is_resource($pipe))) > 0) {
            throw new ArrayItemsIsNotResourcesException();
        }
    }
}
