<?php

namespace FillObjectHelper;

class Type
{
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_OBJECT = 'object';
    public const TYPE_CALLABLE = 'callable';
    public const TYPE_BOOL = 'bool';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY = 'array';
    public const TYPE_NULL = 'null';

    public function __construct(private \ReflectionUnionType|\ReflectionNamedType $type)
    {
    }

    public function isUnionType(): bool
    {
        return $this->type instanceof \ReflectionUnionType;
    }

    /**
     * @return \ReflectionNamedType[]
     */
    public function getTypes(): array
    {
        return $this->isUnionType() ? $this->type : [$this->type];
    }

    public function isRequired(): bool
    {
        foreach ($this->getTypes() as $type) {
            if ($type->allowsNull()) {
                return false;
            }
        }

        return true;
    }

    public function getTypeClass(): ?string
    {
        foreach ($this->getTypes() as $type) {
            if (!in_array($type->getName(), self::getDefaultTypes(), true) && class_exists($type->getName())) {
                return $type->getName();
            }
        }

        return null;
    }

    public function isAllowType(string $typeValue): bool
    {
        $typeNames = array_map(static fn($type) => $type->getName(), $this->getTypes());

        return in_array($typeValue, $typeNames, true);
    }

    public static function getDefaultTypes(): array
    {
        return [
            self::TYPE_INT,
            self::TYPE_FLOAT,
            self::TYPE_OBJECT,
            self::TYPE_CALLABLE,
            self::TYPE_BOOL,
            self::TYPE_STRING,
            self::TYPE_ARRAY,
            self::TYPE_NULL,
        ];
    }
}