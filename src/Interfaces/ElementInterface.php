<?php

namespace FillObjectHelper\Interfaces;

interface ElementInterface
{
    public function isUnionType(): bool;

    /**
     * @return \ReflectionNamedType[]
     */
    public function getType(): array;

    public function isRequired(): bool;

    // @todo parse phpDOC to know about type of class
    public function getTypeClass(): ?string;

    public function isAllowType(string $typeValue): bool;

    public function setValue(object $dto, mixed $value): void;

    public function isInitialized(object $dto): bool;
}