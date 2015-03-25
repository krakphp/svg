<?php

namespace Krak\Svg;

class TopDownIterator implements \IteratorAggregate
{
    private $root;

    public function __construct(Element\AbstractElement $root)
    {
        $this->root = $root;
    }

    public function getIterator()
    {
        return krak_svg_iter_top_down($this->root);
    }
}
