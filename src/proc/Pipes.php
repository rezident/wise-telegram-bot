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
    private array $streams;

    public function __construct(array $streams)
    {
        if (\count(static::DESCRIPTOR) !== \count($streams)) {
            throw new WrongArraySizeException(\count($streams));
        }

        if (\count(array_filter($streams, fn ($pipe) => !\is_resource($pipe))) > 0) {
            throw new ArrayItemsIsNotResourcesException();
        }

        $this->streams = $streams;
        $this->unblockStreams();
    }

    private function unblockStreams(): void
    {
        array_walk($this->streams, fn ($pipe) => stream_set_blocking($pipe, false));
    }
}
