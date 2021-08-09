<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\BoolDto;
use PHPUnit\Framework\TestCase;

class BoolTest extends TestCase
{
    public function testBoolDto(): void
    {
        $data = [
            'bool1' => true,
            'bool2' => false,
            'bool3' => true,
            'bool4' => false,
            'bool5' => false,
            'bool6' => true,
            'bool7' => false,
        ];

        $dto = FillObjectService::fill(BoolDto::class, $data);

        $this->assertInstanceOf(BoolDto::class, $dto);
        $this->assertTrue($dto->getBool1());
        $this->assertFalse($dto->getBool2());
        $this->assertFalse($dto->getBool3());
        $this->assertFalse($dto->getBool4());
        $this->assertFalse($dto->getBool5());
        $this->assertTrue($dto->getBool6());
        $this->assertFalse($dto->getBool7());
    }

    public function testNotRequired()
    {
        $data = [
            'bool1' => true,
            'bool2' => true,
            'bool3' => false
        ];

        $dto = FillObjectService::fill(BoolDto::class, $data);

        $this->assertInstanceOf(BoolDto::class, $dto);
        $this->assertTrue($dto->getBool1());
        $this->assertTrue($dto->getBool2());
        $this->assertTrue($dto->getBool3());
        $this->assertNull($dto->getBool4());
        $this->assertNull($dto->getBool5());
        $this->assertNull($dto->getBool6());
        $this->assertNull($dto->getBool7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'bool1' => static fn() => 'What ?',
            'bool2' => false,
            'bool3' => [],
            'bool4' => new \StdClass()
        ];

        $dto = FillObjectService::fill(BoolDto::class, $data);

        $this->assertInstanceOf(BoolDto::class, $dto);
        $this->assertFalse($dto->getBool1());
        $this->assertFalse($dto->getBool2());
        $this->assertFalse($dto->getBool3());
        $this->assertNull($dto->getBool4());
        $this->assertNull($dto->getBool5());
        $this->assertNull($dto->getBool6());
        $this->assertNull($dto->getBool7());
    }
}