<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\UnionDto;
use PHPUnit\Framework\TestCase;

class UnionTest extends TestCase
{
    public function testUnionDto(): void
    {
        $data = [
            'union1' => 12322,
            'union2' => 90.33235,
            'union3' => new \StdClass,
            'union4' => 'Hello',
            'union5' => 61,
            'union6' => (object) ['key' => 'value'],
            'union7' => [1, 2, 3],
        ];

        $dto = FillObjectService::fill(UnionDto::class, $data);

        $this->assertInstanceOf(UnionDto::class, $dto);
        $this->assertEquals($dto->getUnion1(), $data['union1']);
        $this->assertEquals($dto->getUnion2(), $data['union2']);
        $this->assertEquals($dto->getUnion3(), $data['union3']);
        $this->assertEquals($dto->getUnion4(), $data['union4']);
        $this->assertEquals($dto->getUnion5(), $data['union5']);
        $this->assertEquals($dto->getUnion6(), $data['union6']);
        $this->assertEquals($dto->getUnion7(), $data['union7']);
    }

    public function testNotRequired()
    {
        $data = [
            'union1' => 'Str',
            'union2' => -453
        ];

        $dto = FillObjectService::fill(UnionDto::class, $data);

        $this->assertInstanceOf(UnionDto::class, $dto);
        $this->assertEquals($dto->getUnion1(), $data['union1']);
        $this->assertEquals($dto->getUnion2(), $data['union2']);
        $this->assertNull($dto->getUnion3());
        $this->assertNull($dto->getUnion4());
        $this->assertNull($dto->getUnion5());
        $this->assertNull($dto->getUnion6());
        $this->assertNull($dto->getUnion7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'union1' => static fn() => 'What ?',
            'union2' => false,
            'union4' => [1, 2, 3],
            'union5' => -543.34,
            'union6' => true
        ];

        $dto = FillObjectService::fill(UnionDto::class, $data);

        $this->assertInstanceOf(UnionDto::class, $dto);
        $this->assertEquals(5, $dto->getUnion1());
        $this->assertEquals(55.55, $dto->getUnion2());
        $this->assertNull($dto->getUnion3());
        $this->assertNull($dto->getUnion4());
        $this->assertNull($dto->getUnion5());
        $this->assertNull($dto->getUnion6());
        $this->assertNull($dto->getUnion7());
    }
}