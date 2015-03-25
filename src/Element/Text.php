<?php

namespace Krak\Svg\Element;

class Text extends AbstractElement
{
    private $text = '';
    public function getChildren()
    {
        return [];
    }

    public function getTagName()
    {
        return 'text';
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }
}
