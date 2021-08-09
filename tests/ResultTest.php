<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\ResultDto;
use FillObjectHelper\Tests\Mocks\ResultChildrenDto;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'firstName' => 'Ivan',
            'lastName' => 'Maltsev',
            'age' => 30,
            'position' => 'Full-stack web developer',
            'projects' => ['example.com', 'example2.com'],
            'manager' => [
                'uuid' => 'a34da-232df-33fss-9092',
                'name' => 'Daria Maltseva',
                'contacts' => fn() => [
                    'email' => 'example@gmail.com',
                    'phone' => '+44 7999 999 9999'
                ]
            ]
        ];

        $dto = FillObjectService::fill(ResultDto::class, $data);

        $this->assertInstanceOf(ResultDto::class, $dto);
        $this->assertEquals($dto->firstName, $data['firstName']);
        $this->assertEquals($dto->lastName, $data['lastName']);
        $this->assertEquals($dto->getFullName(), $data['firstName'] . ' ' . $data['lastName']);
        $this->assertEquals($dto->age, $data['age']);
        $this->assertEquals($dto->position, $data['position']);
        $this->assertInstanceOf(ResultChildrenDto::class, $dto->manager);
        $this->assertEquals($dto->manager?->name, $data['manager']['name']);
        $this->assertEquals($dto->manager?->uuid, $data['manager']['uuid']);
        $this->assertTrue(is_callable($dto->manager?->contacts));
        $this->assertEquals(call_user_func($dto->manager?->contacts), call_user_func($data['manager']['contacts']));
    }

    public function testCheckEmptyData()
    {
        $data = [
            'manager' => [

            ]
        ];

        $dto = FillObjectService::fill(ResultDto::class, $data);

        $this->assertInstanceOf(ResultDto::class, $dto);
        $this->assertEquals('', $dto->firstName);
        $this->assertEquals('', $dto->lastName);
        $this->assertEquals('', $dto->getFullName());
        $this->assertEquals(0, $dto->age);
        $this->assertEquals('', $dto->position);
        $this->assertInstanceOf(ResultChildrenDto::class, $dto->manager);
        $this->assertEquals('', $dto->manager?->name);
        $this->assertEquals('', $dto->manager?->uuid);
        $this->assertNull($dto->manager?->contacts);
    }

    public function testIncorrectData()
    {
        $data = [
            'firstName' => [],
            'lastName' => false,
            'age' => -45.34,
            'position' => (object) ['key' => 'value'],
            'projects' => -1,
            'manager' => fn() => null
        ];

        $dto = FillObjectService::fill(ResultDto::class, $data);

        $this->assertInstanceOf(ResultDto::class, $dto);
        $this->assertEquals('', $dto->firstName);
        $this->assertEquals('', $dto->lastName);
        $this->assertEquals('', $dto->getFullName());
        $this->assertEquals(0, $dto->age);
        $this->assertEquals('', $dto->position);
        $this->assertNull($dto->manager);
    }
}