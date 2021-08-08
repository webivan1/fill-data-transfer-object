<?php

namespace FillObjectHelper;

abstract class BaseElement
{
    public static function getDefaultTypes(): array
    {
        return ['int', 'float', 'object', 'callable', 'bool', 'string', 'array', 'null'];
    }
}