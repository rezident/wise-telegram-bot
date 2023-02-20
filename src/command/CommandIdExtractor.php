<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\command;

class CommandIdExtractor
{
    public function extract(\ReflectionClass $reflection): string
    {
        return $this->getIdFromAttribute($reflection) ?? $this->getIdFromClassName($reflection);
    }

    private function getIdFromAttribute(\ReflectionClass $reflection): ?string
    {
        $attribute = $reflection->getAttributes(Id::class)[0] ?? null;
        $attributeInstance = $attribute?->newInstance();

        return $attributeInstance instanceof Id ? $attributeInstance->getId() : null;
    }

    private function getIdFromClassName(\ReflectionClass $reflection): string
    {
        $shortClassNameWithCutCommand = preg_replace('/Command$/', '', $reflection->getShortName());
        $command = preg_replace('/([A-Z])/', '_$1', $shortClassNameWithCutCommand);

        return strtolower(trim($command, '_'));
    }
}
