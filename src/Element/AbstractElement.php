<?php

namespace Krak\Svg\Element;

abstract class AbstractElement
{
    protected $children = [];
    protected $x;
    protected $attributes;
    protected $hints = [];

    public function __construct()
    {
        $this->attributes = new AttributeCollection();
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getAttribute($type)
    {
        return $this->attributes->getAttribute($type);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function appendChild(AbstractElement $el)
    {
        $this->children[] = $el;
    }

    public function setAttributes(AttributeCollection $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setHint($key, $value = null)
    {
        $this->hints[$key] = $value;
    }
    public function hasHint($key)
    {
        return array_key_exists($key, $this->hints);
    }
    public function getHint($key)
    {
        return array_key_exists($key, $this->hints)
            ? $this->hints[$key]
            : null;
    }

    abstract public function getTagName();
}
