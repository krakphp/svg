<?php

namespace Krak\Svg\Tests;

use Krak\Svg;

class StringSvgSerializerTest extends TestCase
{
    public function testSerializeSvg()
    {
        $svg = new Svg\Element\Svg();
        $rect = new Svg\Element\Rect();
        $rect->getAttributes()->setWidth(100)->setHeight(10);
        $rect->appendChild(clone $rect);
        $svg->appendChild($rect);

        $rect1 = new Svg\Element\Rect();
        $rect1->getAttributes()->setWidth(400)->setHeight(40);
        $svg->appendChild($rect1);

        $text1 = new Svg\Element\Text();
        $text1->setText('abc');
        $svg->appendChild($text1);

        $defs = new Svg\Element\Defs();
        $defs->setContent('<font/>');
        $svg->appendChild($defs);

        $serializer = new Svg\StringSvgSerializer(false);
        $str = $serializer->serializeSvg($svg);

        $expected = <<<SVG
<svg>
  <rect width="100" height="10">
    <rect width="100" height="10"/>
  </rect>
  <rect width="400" height="40"/>
  <text>abc</text>
  <defs><font/></defs>
</svg>

SVG;
        $this->assertEquals($expected, $str);
    }
}
