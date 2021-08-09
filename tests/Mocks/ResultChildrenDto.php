<?php

declare(strict_types=1);

namespace FillObjectHelper\Tests\Mocks;

class ResultChildrenDto
{
    public string $uuid;
    public string $name;
    public ?\Closure $contacts;
}