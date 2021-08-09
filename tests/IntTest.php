<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\IntDto;
use PHPUnit\Framework\TestCase;

class IntTest extends TestCase
{
    public function testIntDto(): void
    {
        $data = [
            'int1' => 100,
            'int2' => 90,
            'int3' => 80,
            'int4' => 70,
            'int5' => 61,
            'int6' => 3,
            'int7' => 0,
        ];

        $dto = FillObjectService::fill(IntDto::class, $data);

        $this->assertInstanceOf(IntDto::class, $dto);
        $this->assertEquals($dto->getInt1(), $data['int1']);
        $this->assertEquals($dto->getInt2(), $data['int2']);
        $this->assertEquals($dto->getInt3(), $data['int3'] + 100);
        $this->assertEquals($dto->getInt4(), $data['int4']);
        $this->assertEquals($dto->getInt5(), $data['int5']);
        $this->assertEquals($dto->getInt6(), $data['int6']);
        $this->assertEquals($dto->getInt7(), $data['int7']);
    }

    public function testNotRequired()
    {
        $data = [
            'int1' => 77,
            'int2' => 66,
            'int3' => 55
        ];

        $dto = FillObjectService::fill(IntDto::class, $data);

        $this->assertInstanceOf(IntDto::class, $dto);
        $this->assertEquals($dto->getInt1(), $data['int1']);
        $this->assertEquals($dto->getInt2(), $data['int2']);
        $this->assertEquals($dto->getInt3(), $data['int3'] + 100);
        $this->assertNull($dto->getInt4());
        $this->assertNull($dto->getInt5());
        $this->assertNull($dto->getInt6());
        $this->assertNull($dto->getInt7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'int1' => static fn() => 'What ?',
            'int2' => false,
            'int3' => [],
            'int4' => new \StdClass()
        ];

        $dto = FillObjectService::fill(IntDto::class, $data);

        $this->assertInstanceOf(IntDto::class, $dto);
        $this->assertEquals(0, $dto->getInt1());
        $this->assertEquals(0, $dto->getInt2());
        $this->assertEquals(100, $dto->getInt3());
        $this->assertNull($dto->getInt4());
        $this->assertNull($dto->getInt5());
        $this->assertNull($dto->getInt6());
        $this->assertNull($dto->getInt7());
    }
}