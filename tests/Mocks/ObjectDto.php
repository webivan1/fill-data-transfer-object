<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class ObjectDto
{
    private ?object $object1;
    public ?object $object2;
    private ?\Closure $object3;
    public ?object $object4;
    public object|null $object5;
    private ?object $object6;
    private null|object $object7;

    public function __construct(object $value1)
    {
        $this->object1 = $value1;
    }

    public function setObject3(?callable $value): void
    {
        $this->object3 = $value;
    }

    public function setObject6(?object $value): void
    {
        $this->object6 = $value;
    }

    public function setObject7(null|object $value): void
    {
        $this->object7 = $value;
    }

    public function getObject1(): ?\StdClass
    {
        return $this->object1;
    }

    public function getObject2(): ?object
    {
        return $this->object2;
    }

    public function getObject3(): ?\Closure
    {
        return $this->object3;
    }

    public function getObject4(): ?object
    {
        return $this->object4;
    }

    public function getObject5(): ?object
    {
        return $this->object5;
    }

    public function getObject6(): ?object
    {
        return $this->object6;
    }

    public function getObject7(): ?object
    {
        return $this->object7;
    }
}