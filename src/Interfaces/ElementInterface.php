<?php

namespace FillObjectHelper\Interfaces;

interface ElementInterface
{
    public function getType(): \ReflectionNamedType|\ReflectionUnionType;

    public function setValue(object $dto, mixed $value): void;

    public function isInitialized(object $dto): bool;
}