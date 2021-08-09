<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class ResultDto
{
    public string $firstName;
    public string $lastName;
    public int $age;
    public string $position;
    /** @var string[] */
    public array $projects;
    public ?ResultChildrenDto $manager;

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }
}