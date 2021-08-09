<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\ArrayDto;
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testArrayDto(): void
    {
        $data = [
            'array1' => [1, 2, 3],
            'array2' => ['Hi'],
            'array3' => [1],
            'array4' => [0, 0, 0, 1, 0, 1],
            'array5' => [[[1]]],
            'array6' => [[0, 1][1]],
            'array7' => ['Str...'],
        ];

        $dto = FillObjectService::fill(ArrayDto::class, $data);

        $this->assertInstanceOf(ArrayDto::class, $dto);
        $this->assertEquals($dto->getArray1(), $data['array1']);
        $this->assertEquals($dto->getArray2(), $data['array2']);
        $this->assertEquals($dto->getArray3(), $data['array3'] + [1]);
        $this->assertEquals($dto->getArray4(), $data['array4']);
        $this->assertEquals($dto->getArray5(), $data['array5']);
        $this->assertEquals($dto->getArray6(), $data['array6']);
        $this->assertEquals($dto->getArray7(), $data['array7']);
    }

    public function testNotRequired()
    {
        $data = [
            'array1' => ['Str1', 'Str2', [1, 2, 3]],
            'array2' => ['1', 1, true, null],
            'array3' => ['key' => 'value']
        ];

        $dto = FillObjectService::fill(ArrayDto::class, $data);

        $this->assertInstanceOf(ArrayDto::class, $dto);
        $this->assertEquals($dto->getArray1(), $data['array1']);
        $this->assertEquals($dto->getArray2(), $data['array2']);
        $this->assertEquals($dto->getArray3(), $data['array3'] + [1]);
        $this->assertNull($dto->getArray4());
        $this->assertNull($dto->getArray5());
        $this->assertNull($dto->getArray6());
        $this->assertNull($dto->getArray7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'array1' => static fn() => 'What ?',
            'array2' => false,
            'array3' => 1,
            'array4' => new \StdClass()
        ];

        $dto = FillObjectService::fill(ArrayDto::class, $data);

        $this->assertInstanceOf(ArrayDto::class, $dto);
        $this->assertEquals([], $dto->getArray1());
        $this->assertEquals([], $dto->getArray2());
        $this->assertEquals([1], $dto->getArray3());
        $this->assertNull($dto->getArray4());
        $this->assertNull($dto->getArray5());
        $this->assertNull($dto->getArray6());
        $this->assertNull($dto->getArray7());
    }
}