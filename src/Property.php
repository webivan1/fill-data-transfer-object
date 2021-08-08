<?php

declare(strict_types=1);

namespace FillObjectHelper;

use FillObjectHelper\Interfaces\ElementInterface;

class Property extends BaseElement implements ElementInterface
{
    public function __construct(private \ReflectionProperty $property)
    {
        if (!$this->property->isPublic()) {
            $this->property->setAccessible(true);
        }
    }

    public function isUnionType(): bool
    {
        return $this->property->getType() instanceof \ReflectionUnionType;
    }

    /**
     * @return \ReflectionNamedType[]
     */
    public function getType(): array
    {
        return $this->isUnionType() ? $this->property->getType() : [$this->property->getType()];
    }

    public function isRequired(): bool
    {
        foreach ($this->getType() as $type) {
            if ($type->allowsNull()) {
                return false;
            }
        }

        return true;
    }

    public function getTypeClass(): ?string
    {
        foreach ($this->getType() as $type) {
            if (!in_array($type->getName(), self::getDefaultTypes(), true) && class_exists($type->getName())) {
                return $type->getName();
            }
        }

        return null;
    }

    public function isAllowType(string $typeValue): bool
    {
        foreach ($this->getType() as $type) {
            if ($typeValue === $type->getName()) {
                return true;
            }
        }

        return false;
    }

    public function setValue(object $dto, mixed $value): void
    {
        $this->property->setValue($dto, $value);
    }

    public function isInitialized(object $dto): bool
    {
        return $this->property->isInitialized($dto);
    }
}