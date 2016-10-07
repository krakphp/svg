<?php

namespace Krak\Svg\Element;

class SimpleElement extends AbstractElement
{
    private $tag_name;

    public function __construct($tag_name) {
        $this->tag_name = $tag_name;
    }

    public function getTagName() {
        return $this->tag_name;
    }
}
