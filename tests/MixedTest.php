<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\MixedDto;
use PHPUnit\Framework\TestCase;

class MixedTest extends TestCase
{
    public function testMixedDto(): void
    {
        $data = [
            'mixed1' => 1,
            'mixed2' => 2.23,
            'mixed3' => false,
            'mixed4' => null,
            'mixed5' => [1, 2, 3],
            'mixed6' => static fn() => '',
            'mixed7' => new \StdClass(),
        ];

        $dto = FillObjectService::fill(MixedDto::class, $data);

        $this->assertInstanceOf(MixedDto::class, $dto);
        $this->assertEquals($dto->getMixed1(), $data['mixed1']);
        $this->assertEquals($dto->getMixed2(), $data['mixed2']);
        $this->assertEquals($dto->getMixed3(), $data['mixed3']);
        $this->assertEquals($dto->getMixed4(), $data['mixed4']);
        $this->assertEquals($dto->getMixed5(), $data['mixed5']);
        $this->assertEquals($dto->getMixed6(), $data['mixed6']);
        $this->assertEquals($dto->getMixed7(), $data['mixed7']);
    }

    public function testNotRequired()
    {
        $data = [
            'mixed1' => ['Str1', 'Str2', [1, 2, 3]],
            'mixed2' => 'String...',
            'mixed3' => 453.22
        ];

        $dto = FillObjectService::fill(MixedDto::class, $data);

        $this->assertInstanceOf(MixedDto::class, $dto);
        $this->assertEquals($dto->getMixed1(), $data['mixed1']);
        $this->assertEquals($dto->getMixed2(), $data['mixed2']);
        $this->assertEquals($dto->getMixed3(), $data['mixed3']);
        $this->assertNull($dto->getMixed4());
        $this->assertNull($dto->getMixed5());
        $this->assertNull($dto->getMixed6());
        $this->assertNull($dto->getMixed7());
    }
}