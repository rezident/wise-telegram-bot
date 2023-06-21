<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\di;

class SignatureComparator
{
    private const UNION_SEPARATOR = '|';
    private const TYPES_SEPARATOR = ',';

    public function compare(string $classNameA, string $methodA, string $classNameB, string $methodB): bool
    {
        if (!method_exists($classNameA, $methodA) || !method_exists($classNameB, $methodB)) {
            return false;
        }

        $mReflectA = new \ReflectionMethod($classNameA, $methodA);
        $mReflectB = new \ReflectionMethod($classNameB, $methodB);

        if ($this->getParametersString($mReflectA) !== $this->getParametersString($mReflectB)) {
            return false;
        }

        if ($this->getTypeString($mReflectA->getReturnType()) !== $this->getTypeString($mReflectB->getReturnType())) {
            return false;
        }

        return true;
    }

    private function getParametersString(\ReflectionMethod $method): string
    {
        return implode(
            self::TYPES_SEPARATOR,
            array_map(fn ($param) => $this->getTypeString($param->getType()), $method->getParameters()),
        );
    }

    private function getTypeString(\ReflectionType $type): string
    {
        if ($type instanceof \ReflectionNamedType) {
            return sprintf('%s%s', $type->allowsNull() ? '?' : '', $type->getName());
        }

        if ($type instanceof \ReflectionUnionType) {
            return implode(
                self::UNION_SEPARATOR,
                array_map(fn ($param) => $this->getTypeString($param), $type->getTypes()),
            );
        }

        return '';
    }
}
