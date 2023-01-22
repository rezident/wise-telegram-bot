<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\reader;

class ClassNameExtractor
{
    public function extract(string $path): string
    {
        $contents = file_get_contents($path);
        preg_match('/^namespace ([^;]+);$/m', $contents, $matches);
        $namespace = $matches[1];
        preg_match('/^class (\w+)/m', $contents, $matches);
        $shortClassName = $matches[1];

        return sprintf('%s\\%s', $namespace, $shortClassName);
    }
}
