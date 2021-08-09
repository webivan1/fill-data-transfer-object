<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class UnionDto
{
    private string|int $union1 = 5;
    public int|float $union2 = 55.55;
    private mixed $union3;
    public string|float|null $union4;
    public int|null $union5;
    private float|object|null $union6;
    private array|string|null $union7;

    public function setUnion3(mixed $value): void
    {
        $this->union3 = $value;
    }

    public function setUnion6(float|object|null $value): void
    {
        $this->union6 = $value;
    }

    public function setUnion7(array|string|null $value): void
    {
        $this->union7 = $value;
    }

    public function getUnion1(): int|string
    {
        return $this->union1;
    }

    public function getUnion2(): float|int
    {
        return $this->union2;
    }

    public function getUnion3(): mixed
    {
        return $this->union3;
    }

    public function getUnion4(): float|string|null
    {
        return $this->union4;
    }

    public function getUnion5(): ?int
    {
        return $this->union5;
    }

    public function getUnion6(): float|object|null
    {
        return $this->union6;
    }

    public function getUnion7(): array|string|null
    {
        return $this->union7;
    }
}