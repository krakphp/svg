<?php

namespace Krak\Svg\Tests;

use Krak\Svg;

class SerializerTest extends TestCase
{
    public function testSerializeSvg()
    {
        $svg = new Svg\Element\Svg();
        $res = svg\serialize_svg(function($el) {return 'abc';}, $svg);

        $this->assertEquals('abc', $res);
    }
}
