<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class MixedDto
{
    private mixed $mixed1;
    public mixed $mixed2;
    private mixed $mixed3;
    public mixed $mixed4;
    public mixed $mixed5;
    private mixed $mixed6;
    private mixed $mixed7;

    public function __construct(mixed $value1)
    {
        $this->mixed1 = $value1;
    }

    public function setMixed3(mixed $value): void
    {
        $this->mixed3 = $value;
    }

    public function setMixed6(mixed $value): void
    {
        $this->mixed6 = $value;
    }

    public function setMixed7(mixed $value): void
    {
        $this->mixed7 = $value;
    }

    public function getMixed1(): mixed
    {
        return $this->mixed1;
    }

    public function getMixed2(): mixed
    {
        return $this->mixed2;
    }

    public function getMixed3(): mixed
    {
        return $this->mixed3;
    }

    public function getMixed4(): mixed
    {
        return $this->mixed4;
    }

    public function getMixed5(): mixed
    {
        return $this->mixed5;
    }

    public function getMixed6(): mixed
    {
        return $this->mixed6;
    }

    public function getMixed7(): mixed
    {
        return $this->mixed7;
    }
}