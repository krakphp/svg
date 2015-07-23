<?php

namespace Krak\Tests;

use Krak\Svg,
    Krak\Tests\TestCase;

class StringSvgSerializerTest extends TestCase
{
    public function testSerializeSvg()
    {
        $svg = new Svg\Element\Svg();
        $rect = new Svg\Element\Rect();
        $rect->getAttributes()->setWidth('100');
        $svg->appendChild($rect);

        $serializer = new Svg\StringSvgSerializer(false);
        $str = $serializer->serializeSvg($svg);
        $expected = <<<SVG
<svg>
  <rect width="100"/>
</svg>

SVG;
        $this->assertEquals($expected, $str);
    }
}
