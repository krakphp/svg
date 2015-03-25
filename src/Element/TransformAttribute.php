<?php

namespace Krak\Svg\Element;

class TransformAttribute implements Attribute
{
    private $types = [];

    public function getKey()
    {
        return 'transform';
    }

    public function addType($type, $args)
    {
        $this->types[] = [$type, $args];
    }

    public function translate($x, $y = 0)
    {
        $this->addType('translate', [$x, $y]);
        return $this;
    }

    public function scale($x, $y = 0)
    {
        $this->addType('scale', [$x, $y]);
        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }
}
