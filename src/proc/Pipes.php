<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\proc;

use Rezident\WiseTelegramBot\proc\exceptions\ArrayItemsIsNotResourcesException;
use Rezident\WiseTelegramBot\proc\exceptions\WrongArraySizeException;

class Pipes
{
    public const DESCRIPTOR = [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']];

    private const READ_BUFFER_SIZE = 8192;

    private const OUT = 1;
    private const ERR = 2;

    private array $streamsBuffer = [];

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
        $this->streamsBuffer = array_fill(0, \count($streams), '');
        $this->unblockStreams();
    }

    public function pullStdout(): string
    {
        return $this->pullAndClearBuffer(self::OUT);
    }

    public function pullStderr(): string
    {
        return $this->pullAndClearBuffer(self::ERR);
    }

    private function pullAndClearBuffer(int $index): string
    {
        $this->readStreams();
        $result = $this->streamsBuffer[$index];
        $this->streamsBuffer[$index] = '';

        return $result;
    }

    private function readStreams(): void
    {
        foreach ([self::OUT, self::ERR] as $index) {
            while ($data = fread($this->streams[$index], self::READ_BUFFER_SIZE)) {
                $this->streamsBuffer[$index] .= $data;
            }
        }
    }

    private function unblockStreams(): void
    {
        array_walk($this->streams, fn ($pipe) => stream_set_blocking($pipe, false));
    }
}
