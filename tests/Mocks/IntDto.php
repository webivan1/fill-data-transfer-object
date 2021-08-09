<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class IntDto
{
    private int $int1;
    public int $int2;
    private int $int3;
    public ?int $int4;
    public int|null $int5;
    private ?int $int6;
    private null|int $int7;

    public function __construct(int $value)
    {
        $this->int1 = $value;
    }

    public function setInt3(int $value): void
    {
        $this->int3 = $value + 100;
    }

    public function setInt6(?int $value): void
    {
        $this->int6 = $value;
    }

    public function setInt7(null|int $value): void
    {
        $this->int7 = $value;
    }

    public function getInt1(): int
    {
        return $this->int1;
    }

    public function getInt2(): int
    {
        return $this->int2;
    }

    public function getInt3(): int
    {
        return $this->int3;
    }

    public function getInt4(): ?int
    {
        return $this->int4;
    }

    public function getInt5(): ?int
    {
        return $this->int5;
    }

    public function getInt6(): ?int
    {
        return $this->int6;
    }

    public function getInt7(): ?int
    {
        return $this->int7;
    }
}