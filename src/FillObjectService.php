<?php

declare(strict_types=1);

namespace FillObjectHelper;

use FillObjectHelper\Interfaces\ElementInterface;

class FillObjectService
{
    public function fillAsArray(string $className, array $params): object
    {
        $reflection = new \ReflectionClass($className);

        $dto = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $prop) {
            $value = $params[$prop->getName()] ?? null;
            $typeOfValue = $this->getTypeOfValue($value);

            if ($reflection->hasMethod($methodName = Method::getSetterName($prop->getName()))) {
                $element = new Method($reflection->getMethod($methodName));
            } else {
                $element = new Property($prop);
            }

            $type = new Type($element->getType());

            if (($newClassName = $type->getTypeClass()) && $typeOfValue === 'array') {
                $element->setValue($dto, $this->fillAsArray($newClassName, $value));
                continue;
            }

            if ($type->isAllowType($typeOfValue)) {
                $element->setValue($dto, $value);
            } else if (!$type->isRequired()) {
                $element->setValue($dto, null);
            } else if (!$type->isUnionType() && !$element->isInitialized($dto)) {
                $this->setEmptyValueByElement($element, $type, $dto);
            }
        }

        return $dto;
    }

    public static function fill(string $className, array $params): object
    {
        return (new self)->fillAsArray($className, $params);
    }

    public static function fillJson(string $className, string $json): object
    {
        $data = json_decode($json, true);

        if (!$data) {
            throw new \InvalidArgumentException('Incorrect json value');
        }

        return self::fill($className, $data);
    }

    private function setEmptyValueByElement(ElementInterface $element, Type $types, object $dto): void
    {
        $allowTypes = ['int', 'float', 'array', 'string'];

        foreach ($types->getTypes() as $type) {
            if (in_array($type->getName(), $allowTypes, true)) {
                $element->setValue($dto, match($type->getName()) {
                    'int', 'float' => 0,
                    'array' => [],
                    'string' => ''
                });
            }
        }
    }

    private function getTypeOfValue(mixed $value): string
    {
        if (is_callable($value)) {
            return Type::TYPE_CALLABLE;
        }

        return match(gettype($value)) {
            'integer' => Type::TYPE_INT,
            'double' => Type::TYPE_FLOAT,
            'boolean' => Type::TYPE_BOOL,
            'object' => Type::TYPE_OBJECT,
            'array' => Type::TYPE_ARRAY,
            'NULL' => Type::TYPE_NULL,
            default => Type::TYPE_STRING,
        };
    }
}