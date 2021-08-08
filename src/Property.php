<?php

declare(strict_types=1);

namespace FillObjectHelper;

use FillObjectHelper\Interfaces\ElementInterface;

class Property implements ElementInterface
{
    public function __construct(private \ReflectionProperty $property)
    {
        if (!$this->property->isPublic()) {
            $this->property->setAccessible(true);
        }
    }

    public function setValue(object $dto, mixed $value): void
    {
        $this->property->setValue($dto, $value);
    }

    public function isInitialized(object $dto): bool
    {
        return $this->property->isInitialized($dto);
    }

    public function getType(): \ReflectionNamedType|\ReflectionUnionType
    {
        return $this->property->getType();
    }
}