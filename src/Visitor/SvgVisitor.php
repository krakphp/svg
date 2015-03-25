<?php

namespace Krak\Svg\Visitor;

use Krak\Svg\Element\AbstractElement;

interface SvgVisitor
{
    public function visitElement(AbstractElement $element);
}
