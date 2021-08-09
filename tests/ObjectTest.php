<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\FillObjectService;
use FillObjectHelper\Tests\Mocks\ObjectDto;
use PHPUnit\Framework\TestCase;

class ObjectTest extends TestCase
{
    public function testObjectDto(): void
    {
        $data = [
            'object1' => new \StdClass(),
            'object2' => (object) ['key1' => 1, 'key2' => 2],
            'object3' => static fn() => 'Hi',
            'object4' => new \StdClass(),
            'object5' => new \StdClass(),
            'object6' => new \StdClass(),
            'object7' => new \StdClass(),
        ];

        $dto = FillObjectService::fill(ObjectDto::class, $data);

        $this->assertInstanceOf(ObjectDto::class, $dto);
        $this->assertEquals($dto->getObject1(), $data['object1']);
        $this->assertEquals($dto->getObject2(), $data['object2']);
        $this->assertEquals($dto->getObject3(), $data['object3']);
        $this->assertEquals(call_user_func($dto->getObject3()), call_user_func($data['object3']));
        $this->assertEquals($dto->getObject4(), $data['object4']);
        $this->assertEquals($dto->getObject5(), $data['object5']);
        $this->assertEquals($dto->getObject6(), $data['object6']);
        $this->assertEquals($dto->getObject7(), $data['object7']);
    }

    public function testNotRequired()
    {
        $data = [
            'object1' => new \StdClass(),
            'object2' => (object) ['key1' => 1, 'key2' => 2],
            'object3' => static fn() => 'Hi',
        ];

        $dto = FillObjectService::fill(ObjectDto::class, $data);

        $this->assertInstanceOf(ObjectDto::class, $dto);
        $this->assertEquals($dto->getObject1(), $data['object1']);
        $this->assertEquals($dto->getObject2(), $data['object2']);
        $this->assertEquals($dto->getObject3(), $data['object3']);
        $this->assertNull($dto->getObject4());
        $this->assertNull($dto->getObject5());
        $this->assertNull($dto->getObject6());
        $this->assertNull($dto->getObject7());
    }

    public function testIncorrectParams()
    {
        $data = [
            'object1' => 1,
            'object2' => false,
            'object3' => null,
        ];

        $dto = FillObjectService::fill(ObjectDto::class, $data);

        $this->assertInstanceOf(ObjectDto::class, $dto);
        $this->assertNull($dto->getObject1());
        $this->assertNull($dto->getObject2());
        $this->assertNull($dto->getObject3());
        $this->assertNull($dto->getObject4());
        $this->assertNull($dto->getObject5());
        $this->assertNull($dto->getObject6());
        $this->assertNull($dto->getObject7());
    }
}