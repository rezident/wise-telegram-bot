<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\context;

use Rezident\WiseTelegramBot\context\KeyGenerator;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class KeyGeneratorTest extends TestCase
{
    private const PREFIX1 = 'prefix1';
    private const PREFIX2 = 'prefix2';

    private const VALUE1 = 'value1';
    private const VALUE2 = 'value2';

    public function testGenerateSameKey(): void
    {
        $key = (new KeyGenerator(self::PREFIX1))->getKey(self::VALUE1);
        $this->assertEquals($key, (new KeyGenerator(self::PREFIX1))->getKey(self::VALUE1));
    }

    public function testGenerateOtherKeyOnPrefixDiff(): void
    {
        $key = (new KeyGenerator(self::PREFIX1))->getKey(self::PREFIX1);
        $this->assertNotEquals($key, (new KeyGenerator(self::PREFIX2))->getKey(self::VALUE1));
    }

    public function testGenerateOtherKeyOnValueDiff(): void
    {
        $key = (new KeyGenerator(self::PREFIX1))->getKey(self::PREFIX1);
        $this->assertNotEquals($key, (new KeyGenerator(self::PREFIX1))->getKey(self::VALUE2));
    }
}
