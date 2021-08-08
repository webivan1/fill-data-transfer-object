<?php

require_once __DIR__ . '/vendor/autoload.php';

class DTOChild
{
    public string $childName;
}

class DTO
{
    private string $string;
    private float $float;
    public int $int;
    private array $array;
    private ?object $obj;
    private ?object $func = null;
    private ?DTOChild $children;

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $value): void
    {
        $this->string = $value;
    }

    public function setInt(int $value): void
    {
        $this->int = $value;
    }

    public function setFloat(float $value): void
    {
        $this->float = $value;
    }

    public function setFunc(?callable $value): void
    {
        $this->func = $value;
    }

    public function getAll(): array
    {
        return [
            'string' => $this->string,
            'float' => $this->float,
            'int' => $this->int,
            'array' => $this->array,
            'obj' => $this->obj,
            'func' => $this->func,
            'children' => $this->children
        ];
    }
}

$dto = FillObjectHelper\FillObjectService::fill(DTO::class, [
    'string' => 'Hi',
    'float' => 4556.23,
    'int' => 33,
    'array' => ['Hello'],
    'children' => [
        'childName' => 'Child name'
    ],
    'obj' => new \StdClass,
    'func' => fn() => 'some func'
]);

echo '<pre>';
var_dump($dto->getAll());
echo '</pre>';
echo PHP_EOL;