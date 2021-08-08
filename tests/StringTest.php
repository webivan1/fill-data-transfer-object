<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\StringDto;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    public function testStringDto(): void
    {
        $data = [
            'string1' => 'String 1',
            'string2' => 'String 2',
            'string3' => 'String 3',
            'string4' => 'String 4',
            'string5' => 'String 5',
            'string6' => 'String 6',
            'string7' => 'String 7',
        ];

        $dto = FillObjectService::fill(StringDto::class, $data);

        $this->assertInstanceOf(StringDto::class, $dto);
        $this->assertEquals($dto->getString1(), $data['string1']);
        $this->assertEquals($dto->getString2(), $data['string2']);
        $this->assertEquals($dto->getString3(), $data['string3'] . ' - method');
        $this->assertEquals($dto->getString4(), $data['string4']);
        $this->assertEquals($dto->getString5(), $data['string5']);
        $this->assertEquals($dto->getString6(), $data['string6']);
        $this->assertEquals($dto->getString7(), $data['string7']);
    }

    public function testNotRequired()
    {
        $data = [
            'string1' => 'String 1',
            'string2' => 'String 2',
            'string3' => 'String 3'
        ];

        $dto = FillObjectService::fill(StringDto::class, $data);

        $this->assertInstanceOf(StringDto::class, $dto);
        $this->assertEquals($dto->getString1(), $data['string1']);
        $this->assertEquals($dto->getString2(), $data['string2']);
        $this->assertEquals($dto->getString3(), $data['string3'] . ' - method');
        $this->assertNull($dto->getString4());
        $this->assertNull($dto->getString5());
        $this->assertNull($dto->getString6());
        $this->assertNull($dto->getString7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'string1' => static fn() => 'What ?',
            'string2' => false,
            'string3' => [],
            'string4' => new \StdClass()
        ];

        $dto = FillObjectService::fill(StringDto::class, $data);

        $this->assertInstanceOf(StringDto::class, $dto);
        $this->assertEquals($dto->getString1(), '');
        $this->assertEquals($dto->getString2(), '');
        $this->assertEquals($dto->getString3(), ' - method');
        $this->assertNull($dto->getString4());
        $this->assertNull($dto->getString5());
        $this->assertNull($dto->getString6());
        $this->assertNull($dto->getString7());
    }
}