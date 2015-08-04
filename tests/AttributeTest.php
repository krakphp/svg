<?php

namespace Krak\Svg\Tests;

use Krak\Svg\Element;

class AttributeTest extends TestCase
{
    public function testIterToCol()
    {
        $col = element\attr_iter_to_col([
            'width' => 12,
        ]);

        $valid = $col instanceof Element\AttributeCollection &&
            $col->getAttribute('width')->getValue() == 12;

        $this->assertTrue($valid);
    }

    public function testSimpleToString()
    {
        $attr = new Element\SimpleAttribute('key', 'value');
        $this->assertEquals(
            'key="value"',
            element\attr_simple_to_string($attr)
        );
    }

    public function testTransformToString()
    {
        $attr = new Element\TransformAttribute();
        $attr->scale(0, 0);
        $attr->translate(1, 1);

        $this->assertEquals(
            'transform="scale(0 0) translate(1 1)"',
            element\attr_transform_to_string($attr)
        );
    }
}
