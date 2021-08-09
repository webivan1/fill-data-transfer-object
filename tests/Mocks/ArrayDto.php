<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class ArrayDto
{
    private array $array1;
    public array $array2;
    private array $array3;
    public ?array $array4;
    public array|null $array5;
    private ?array $array6;
    private null|array $array7;

    public function __construct(array $value1)
    {
        $this->array1 = $value1;
    }

    public function setArray3(array $value): void
    {
        $this->array3 = $value + [1];
    }

    public function setArray6(?array $value): void
    {
        $this->array6 = $value;
    }

    public function setArray7(null|array $value): void
    {
        $this->array7 = $value;
    }

    public function getArray1(): array
    {
        return $this->array1;
    }

    public function getArray2(): array
    {
        return $this->array2;
    }

    public function getArray3(): array
    {
        return $this->array3;
    }

    public function getArray4(): ?array
    {
        return $this->array4;
    }

    public function getArray5(): ?array
    {
        return $this->array5;
    }

    public function getArray6(): ?array
    {
        return $this->array6;
    }

    public function getArray7(): ?array
    {
        return $this->array7;
    }
}