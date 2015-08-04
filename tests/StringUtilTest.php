<?php

namespace Krak\Svg\Tests;

use Krak\Svg\StringUtil;

class StringUtilTest extends TestCase
{
    public function testMapJoin()
    {
        $vals = ['a', 'b', 'c'];
        $joined = stringutil\map_join($vals, '-', function($val) {
            return $val;
        });

        $this->assertEquals('a-b-c', $joined);
    }
}
