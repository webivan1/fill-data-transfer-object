<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class BoolDto
{
    private bool $bool1 = false;
    public bool $bool2 = false;
    private bool $bool3 = false;
    public ?bool $bool4;
    public bool|null $bool5;
    private ?bool $bool6;
    private null|bool $bool7;

    public function __construct(bool $value1)
    {
        $this->bool1 = $value1;
    }

    public function setBool3(bool $value): void
    {
        $this->bool3 = !$value;
    }

    public function setBool6(?bool $value): void
    {
        $this->bool6 = $value;
    }

    public function setBool7(null|bool $value): void
    {
        $this->bool7 = $value;
    }

    public function getBool1(): bool
    {
        return $this->bool1;
    }

    public function getBool2(): bool
    {
        return $this->bool2;
    }

    public function getBool3(): bool
    {
        return $this->bool3;
    }

    public function getBool4(): ?bool
    {
        return $this->bool4;
    }

    public function getBool5(): ?bool
    {
        return $this->bool5;
    }

    public function getBool6(): ?bool
    {
        return $this->bool6;
    }

    public function getBool7(): ?bool
    {
        return $this->bool7;
    }
}