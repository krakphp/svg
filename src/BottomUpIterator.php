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
        return krak_svg_iter_bottom_up($this->root);
    }
}
