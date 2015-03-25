<?php

namespace Krak\Svg;

use Closure,
    Krak\Svg\Element\AbstractElement;

class SvgWalker
{
    private $iterFactory;
    private $visitor;

    public function __construct($iterFactory, $visitor)
    {
        $this->iterFactory = $iterFactory;
        $this->visitor = $visitor;
    }

    public function walkSvg(AbstractElement $element)
    {
        $iter = $this->iterFactory->__invoke($element);
        foreach ($iter as $el) {
            $this->visitor->visitElement($el);
        }
    }
}
