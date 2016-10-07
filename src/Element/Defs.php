<?php

namespace Krak\Svg\Element;

class Defs extends AbstractElement
{
    private $content;

    public function getTagName() {
        return 'defs';
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
