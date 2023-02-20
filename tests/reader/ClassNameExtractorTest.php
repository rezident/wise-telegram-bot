<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\reader;

use Rezident\WiseTelegramBot\reader\ClassNameExtractor;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class ClassNameExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $extractor = new ClassNameExtractor();
        $this->assertEquals(self::class, $extractor->extract(__FILE__));
    }
}
