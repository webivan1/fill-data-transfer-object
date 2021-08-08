<?php

namespace FillObjectHelper\Tests\Mocks;

class StringDto
{
    private string $string1;
    public string $string2;
    private string $string3;
    public ?string $string4;
    public string|null $string5;
    private ?string $string6;
    private null|string $string7;

    public function __construct(string $str1)
    {
        $this->string1 = $str1;
    }

    public function setString3(string $str): void
    {
        $this->string3 = $str . ' - method';
    }

    public function setString6(?string $str): void
    {
        $this->string6 = $str;
    }

    public function setString7(null|string $str): void
    {
        $this->string7 = $str;
    }

    public function getString1(): string
    {
        return $this->string1;
    }

    public function getString2(): string
    {
        return $this->string2;
    }

    public function getString3(): string
    {
        return $this->string3;
    }

    public function getString4(): ?string
    {
        return $this->string4;
    }

    public function getString5(): ?string
    {
        return $this->string5;
    }

    public function getString6(): ?string
    {
        return $this->string6;
    }

    public function getString7(): ?string
    {
        return $this->string7;
    }
}