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

            if (($newClassName = $element->getTypeClass()) && $typeOfValue === 'array') {
                // @todo Check this array, assoc type array or no

                $element->setValue($dto, $this->fillAsArray($newClassName, $value));
                continue;
            }

            if ($element->isAllowType($typeOfValue)) {
                $element->setValue($dto, $value);
            } else if (!$element->isRequired()) {
                $element->setValue($dto, null);
            } else if (!$element->isInitialized($dto)) {
                $this->setEmptyValueByElement($element, $dto);
            }
        }

        return $dto;
    }

    public function fillAsJson(string $className, string $json): object
    {
        $data = json_decode($json, true);

        if (!$data) {
            throw new \InvalidArgumentException('Incorrect json value');
        }

        return $this->fillAsArray($className, $data);
    }

    public static function fill(string $className, array $params): object
    {
        return (new self)->fillAsArray($className, $params);
    }

    private function setEmptyValueByElement(ElementInterface $element, object $dto): void
    {
        $allowTypes = ['int', 'float', 'array', 'string'];

        foreach ($element->getType() as $type) {
            if (!$element->getTypeClass() && in_array($type->getName(), $allowTypes, true)) {
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
            return 'callable';
        }

        return match(gettype($value)) {
            'integer' => 'int',
            'double' => 'float',
            'boolean' => 'bool',
            'object' => 'object',
            'array' => 'array',
            'NULL' => 'null',
            default => 'string',
        };
    }
}