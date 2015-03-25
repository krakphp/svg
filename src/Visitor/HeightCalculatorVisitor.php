<?php

namespace Krak\Svg\Visitor;

use Krak\Svg\Element\AbstractElement;

class HeightCalculatorVisitor implements SvgVisitor
{
    const HINT = 'needs-height';

    public function visitElement(AbstractElement $element)
    {
        if (!$element->hasHint('needs-height')) {
            return;
        }

        $height = 0;
        foreach ($element->getChildren() as $child) {
            $attr = $child->getAttributes()->getHeight();
            if ($attr) {
                $height += (int) $attr->getValue();
            }
        }
        $element->getAttributes()->setHeight($height);
    }
}
