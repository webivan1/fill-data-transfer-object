<?php

declare(strict_types=1);

namespace FillObjectHelper;

use FillObjectHelper\Interfaces\ElementInterface;

class Method implements ElementInterface
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

    public function getType(): \ReflectionNamedType|\ReflectionUnionType
    {
        return $this->parameter->getType();
    }
}