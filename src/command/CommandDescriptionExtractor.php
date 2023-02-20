<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

class CommandDescriptionExtractor
{
    public function extract(\ReflectionClass $reflectionClass): ?string
    {
        $attribute = $reflectionClass->getAttributes(Description::class)[0] ?? null;
        $attributeInstance = $attribute?->newInstance();

        return $attributeInstance instanceof Description ? $attributeInstance->getDescription() : null;
    }
}
