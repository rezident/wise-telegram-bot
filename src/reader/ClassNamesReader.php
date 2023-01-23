<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\reader;

class ClassNamesReader
{
    public function __construct(private ClassNameExtractor $extractor)
    {
    }

    public function read(string $path): array
    {
        $realpath = realpath($path);
        $pattern = sprintf('%s%s*.php', $realpath, \DIRECTORY_SEPARATOR);

        return array_map(fn ($path) => $this->extractor->extract($path), glob($pattern));
    }
}
