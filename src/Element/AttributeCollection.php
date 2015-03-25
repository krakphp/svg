<?php

namespace Krak\Svg\Element;

use BadMethodCallException,
    IteratorAggregate;

class AttributeCollection implements IteratorAggregate
{
    private $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function setAttribute(Attribute $attr)
    {
        $this->attributes[$attr->getKey()] = $attr;
        return $this;
    }

    public function getAttribute($key)
    {
        return array_key_exists($key, $this->attributes)
            ? $this->attributes[$key]
            : null;
    }

    public function getIterator()
    {
        foreach ($this->attributes as $attr) {
            yield $attr->getKey() => $attr;
        }
    }

    private function camelToDash($str)
    {
        return substr(
            strtolower(
                preg_replace("/([A-Z])/", "-\$1", $str)
            ),
            1
        );
    }

    public static function createFromIterable($iter)
    {
        $col = new self();
        foreach ($attributes as $key => $value) {
            $col->setAttribute(new SimpleAttribute($key, $value));
        }

        return $col;
    }

    public function __call($method, $args)
    {
        $prefix = substr($method, 0, 3);
        $suffix = $this->camelToDash(substr($method, 3));
        if ($prefix == 'get') {
            return $this->getAttribute($suffix);
        }
        else if ($prefix == 'set') {
            $this->setAttribute(new SimpleAttribute($suffix, $args[0]));
            return $this;
        }
        else {
            throw new BadMethodCallException('unkown method: ' . $method);
        }
    }
}
