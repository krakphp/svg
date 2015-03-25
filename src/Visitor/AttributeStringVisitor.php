<?php

namespace Krak\Svg\Visitor;

use Krak\Svg\Element\AbstractElement,
    Krak\Svg\Element\Attribute,
    Krak\Svg\Element\SimpleAttribute,
    Krak\Svg\Element\TransformAttribute;

/**
 * Output attributes as string
 */
class AttributeStringVisitor implements SvgVisitor
{
    private function getValue(Attribute $attr)
    {
        if ($attr instanceof SimpleAttribute) {
            return $this->getSimpleValue($attr);
        }
        if ($attr instanceof TransformAttribute) {
            return $this->getTransformValue($attr);
        }

        return '';
    }

    private function getSimpleValue(SimpleAttribute $attr)
    {
        return $attr->getValue();
    }

    private function getTransformValue(TransformAttribute $attr)
    {
        return implode(
            ' ',
            array_map(function($tuple)
            {
                return $tuple[0] . '(' . implode(' ', $tuple[1]) . ')';
            }, $attr->getTypes())
        );
    }

    public function visitElement(AbstractElement $element)
    {
        $buf = '';
        $fmt = ' %s="%s"';
        foreach ($element->getAttributes() as $attr) {
            $buf .= sprintf($fmt, $attr->getKey(), $this->getValue($attr));
        }

        return $buf;
    }
}
