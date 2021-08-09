<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\Type;
use PHPUnit\Framework\TestCase;
use FillObjectHelper\Method;
use FillObjectHelper\Tests\Mocks\ResultDto;

class MethodTest extends TestCase
{
    private \ReflectionClass $ref;
    private ResultDto $dto;
    private \ReflectionMethod $method;
    private Method $methodObject;

    public function setUp(): void
    {
        parent::setUp();

        $this->ref = new \ReflectionClass(ResultDto::class);
        $this->dto = $this->ref->newInstanceWithoutConstructor();
        $this->method = $this->ref->getMethod(Method::getSetterName('position'));
        $this->methodObject = new Method($this->method);
    }

    public function testIsInitialized()
    {
        $this->assertFalse($this->methodObject->isInitialized($this->dto));
    }

    public function testTypes()
    {
        $type = $this->methodObject->getType();

        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertTrue($type->getName() === Type::TYPE_STRING);
    }

    public function testSetValue()
    {
        $this->methodObject->setValue($this->dto, $str = 'Test string');

        $this->assertEquals($str, $this->dto->position);
    }
}