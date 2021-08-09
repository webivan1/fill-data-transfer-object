<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests;

use FillObjectHelper\Type;
use PHPUnit\Framework\TestCase;
use FillObjectHelper\Property;
use FillObjectHelper\Tests\Mocks\ResultDto;

class TypeTest extends TestCase
{
    private \ReflectionClass $ref;
    private ResultDto $dto;
    private \ReflectionProperty $property;
    private Type $type;

    public function setUp(): void
    {
        parent::setUp();

        $this->ref = new \ReflectionClass(ResultDto::class);
        $this->dto = $this->ref->newInstanceWithoutConstructor();
        $this->property = $this->ref->getProperty('position');
        $this->type = new Type($this->property->getType());
    }

    public function testUnionType(): void
    {
        $this->assertFalse($this->type->isUnionType());
    }

    public function testTypes(): void
    {
        $types = $this->type->getTypes();

        $this->assertIsArray($types);
        $this->assertNotEmpty($types);

        foreach ($types as $type) {
            $this->assertEquals(Type::TYPE_STRING, $type->getName());
        }
    }

    public function testRequired(): void
    {
        $this->assertTrue($this->type->isRequired());
    }

    public function testTypeClass(): void
    {
        $this->assertNull($this->type->getTypeClass());
    }

    public function testIsAllowType(): void
    {
        $this->assertTrue($this->type->isAllowType('string'));
        $this->assertFalse($this->type->isAllowType('array'));
    }
}