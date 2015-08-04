<?php

namespace Krak\Svg\Tests;

use Krak\Svg;

class StringSvgSerializerTest extends TestCase
{
    public function testSerializeSvg()
    {
        $svg = new Svg\Element\Svg();
        $rect = new Svg\Element\Rect();
        $rect->getAttributes()->setWidth('100')->setHeight(10);
        $svg->appendChild($rect);

        $serializer = new Svg\StringSvgSerializer(false);
        $str = $serializer->serializeSvg($svg);
        $expected = <<<SVG
<svg>
  <rect width="100" height="10"/>
</svg>

SVG;
        $this->assertEquals($expected, $str);
    }
}
