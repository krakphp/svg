<?php

namespace Krak\Svg;

class BottomUpIterator implements \IteratorAggregate
{
    private $root;

    public function __construct(Element\AbstractElement $root)
    {
        $this->root = $root;
    }

    public function getIterator()
    {
        return iter_bottom_up($this->root);
    }
}
