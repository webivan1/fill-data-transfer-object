<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\FloatDto;
use PHPUnit\Framework\TestCase;

class FloatTest extends TestCase
{
    public function testFloatDto(): void
    {
        $data = [
            'float1' => 100,
            'float2' => 90.33235,
            'float3' => 80.1,
            'float4' => 70.00,
            'float5' => 61,
            'float6' => 3.56,
            'float7' => 0,
        ];

        $dto = FillObjectService::fill(FloatDto::class, $data);

        $this->assertInstanceOf(FloatDto::class, $dto);
        $this->assertEquals($dto->getFloat1(), $data['float1']);
        $this->assertEquals($dto->getFloat2(), $data['float2']);
        $this->assertEquals($dto->getFloat3(), $data['float3'] + 100);
        $this->assertEquals($dto->getFloat4(), $data['float4']);
        $this->assertEquals($dto->getFloat5(), $data['float5']);
        $this->assertEquals($dto->getFloat6(), $data['float6']);
        $this->assertEquals($dto->getFloat7(), $data['float7']);
    }

    public function testNotRequired()
    {
        $data = [
            'float1' => 77.5675,
            'float2' => 66,
            'float3' => 55.1
        ];

        $dto = FillObjectService::fill(FloatDto::class, $data);

        $this->assertInstanceOf(FloatDto::class, $dto);
        $this->assertEquals($dto->getFloat1(), $data['float1']);
        $this->assertEquals($dto->getFloat2(), $data['float2']);
        $this->assertEquals($dto->getFloat3(), $data['float3'] + 100);
        $this->assertNull($dto->getFloat4());
        $this->assertNull($dto->getFloat5());
        $this->assertNull($dto->getFloat6());
        $this->assertNull($dto->getFloat7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'float1' => static fn() => 'What ?',
            'float2' => false,
            'float3' => [],
            'float4' => new \StdClass()
        ];

        $dto = FillObjectService::fill(FloatDto::class, $data);

        $this->assertInstanceOf(FloatDto::class, $dto);
        $this->assertEquals(0, $dto->getFloat1());
        $this->assertEquals(0, $dto->getFloat2());
        $this->assertEquals(100, $dto->getFloat3());
        $this->assertNull($dto->getFloat4());
        $this->assertNull($dto->getFloat5());
        $this->assertNull($dto->getFloat6());
        $this->assertNull($dto->getFloat7());
    }
}