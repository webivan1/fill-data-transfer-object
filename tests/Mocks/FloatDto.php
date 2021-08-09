<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class FloatDto
{
    private float $float1;
    public float $float2;
    private float $float3;
    public ?float $float4;
    public float|null $float5;
    private ?float $float6;
    private null|float $float7;

    public function __construct(float $value1)
    {
        $this->float1 = $value1;
    }

    public function setFloat3(float $value): void
    {
        $this->float3 = $value + 100;
    }

    public function setFloat6(?float $value): void
    {
        $this->float6 = $value;
    }

    public function setFloat7(null|float $value): void
    {
        $this->float7 = $value;
    }

    public function getFloat1(): float
    {
        return $this->float1;
    }

    public function getFloat2(): float
    {
        return $this->float2;
    }

    public function getFloat3(): float
    {
        return $this->float3;
    }

    public function getFloat4(): ?float
    {
        return $this->float4;
    }

    public function getFloat5(): ?float
    {
        return $this->float5;
    }

    public function getFloat6(): ?float
    {
        return $this->float6;
    }

    public function getFloat7(): ?float
    {
        return $this->float7;
    }
}