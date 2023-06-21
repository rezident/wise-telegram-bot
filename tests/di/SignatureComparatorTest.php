<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\di;

use Rezident\WiseTelegramBot\di\SignatureComparator;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\di\classes\SignatureComparatorStub;

class SignatureComparatorTest extends TestCase
{
    private SignatureComparator $comparator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->comparator = $this->container->get(SignatureComparator::class);
    }

    public function testSameMethod(): void
    {
        $this->assertTrue($this->comparator->compare(
            SignatureComparatorStub::class,
            'simple',
            SignatureComparatorStub::class,
            'simple',
        ));

        $this->assertTrue($this->comparator->compare(
            SignatureComparatorStub::class,
            'withDoubleArgAndUnionReturn',
            SignatureComparatorStub::class,
            'withDoubleArgAndUnionReturn',
        ));
    }

    public function testNotExistMethod(): void
    {
        $this->assertFalse($this->comparator->compare(
            SignatureComparatorStub::class,
            'simple1',
            SignatureComparatorStub::class,
            'simple',
        ));

        $this->assertFalse($this->comparator->compare(
            SignatureComparatorStub::class,
            'simple',
            SignatureComparatorStub::class,
            'simple1',
        ));
    }

    public function testDifferentMethods(): void
    {
        $cn = SignatureComparatorStub::class;
        $methods = (new \ReflectionClass($cn))->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $i => $method) {
            for ($i1 = $i + 1; $i1 < \count($methods); ++$i1) {
                $this->assertFalse($this->comparator->compare($cn, $method->getName(), $cn, $methods[$i1]->getName()));
            }
        }
    }
}
