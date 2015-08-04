<?php

namespace Krak\Svg\Visitor;

use Krak\Svg\Element,
    Krak\Svg\StringUtil;

/**
 * Output attributes as string
 */
class AttributeStringVisitor implements SvgVisitor
{
    private function getAttributeString(Element\Attribute $attr)
    {
        if ($attr instanceof Element\SimpleAttribute) {
            return element\attr_simple_to_string($attr);
        }
        if ($attr instanceof Element\TransformAttribute) {
            return element\attr_transform_to_string($attr);
        }

        return '';
    }

    public function visitElement(Element\AbstractElement $element)
    {
        return stringutil\map_join($element->getAttributes(), ' ', function($attr)
        {
            return $this->getAttributeString($attr);
        });
    }
}
