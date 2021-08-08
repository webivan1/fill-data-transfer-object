<?php

declare(strict_types=1);

namespace FillObjectHelper;

use FillObjectHelper\Interfaces\ElementInterface;

class Method extends BaseElement implements ElementInterface
{
    private \ReflectionParameter $parameter;

    public function __construct(private \ReflectionMethod $method)
    {
        if (!$this->method->isPublic()) {
            $this->method->setAccessible(true);
        }

        if ($this->method->getNumberOfParameters() === 0) {
            throw new FillObjectException('This method ' . $this->method->getName() . ' doesn\'t any parameters');
        }

        $this->parameter = $this->method->getParameters()[0];
    }

    public static function getSetterName(string $propertyName): string
    {
        return 'set' . ucfirst($propertyName);
    }

    public function getPropertyName(): string
    {
        return lcfirst(preg_replace('/^set/', '', $this->method->getName()));
    }

    public function isUnionType(): bool
    {
        return $this->parameter->getType() instanceof \ReflectionUnionType;
    }

    public function getType(): array
    {
        return $this->isUnionType() ? $this->parameter->getType() : [$this->parameter->getType()];
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
        call_user_func([$dto, $this->method->getName()], $value);
    }

    public function isInitialized(object $dto): bool
    {
        $classRef = $this->method->getDeclaringClass();

        if (!$classRef->hasProperty($this->getPropertyName())) {
            return true;
        }

        $property = $classRef->getProperty($this->getPropertyName());
        $property->setAccessible(true);

        return $property->isInitialized($dto);
    }
}