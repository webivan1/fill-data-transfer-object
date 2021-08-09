<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\Type;
use PHPUnit\Framework\TestCase;
use FillObjectHelper\Property;
use FillObjectHelper\Tests\Mocks\ResultDto;

class PropertyTest extends TestCase
{
    private \ReflectionClass $ref;
    private ResultDto $dto;
    private \ReflectionProperty $property;
    private Property $propObject;

    public function setUp(): void
    {
        parent::setUp();

        $this->ref = new \ReflectionClass(ResultDto::class);
        $this->dto = $this->ref->newInstanceWithoutConstructor();
        $this->property = $this->ref->getProperty('position');
        $this->propObject = new Property($this->property);
    }

    public function testIsInitialized()
    {
        $this->assertFalse($this->propObject->isInitialized($this->dto));
    }

    public function testTypes()
    {
        $type = $this->propObject->getType();

        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertTrue($type->getName() === Type::TYPE_STRING);
    }

    public function testSetValue()
    {
        $this->propObject->setValue($this->dto, $str = 'Test string');

        $this->assertEquals($str, $this->dto->position);
    }
}