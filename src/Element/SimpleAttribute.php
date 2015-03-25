<?php

namespace Krak\Svg\Element;

class SimpleAttribute implements Attribute
{
    private $key;
    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return 'simple';
    }

    public function getValue()
    {
        return $this->value;
    }
}
