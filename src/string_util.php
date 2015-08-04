<?php

namespace Krak\Svg\StringUtil;

function map_join($values, $sep, $predicate) {
    $buf = '';
    foreach ($values as $key => $val) {
        $buf .= $sep . $predicate($val, $key);
    }

    return substr($buf, strlen($sep));
}
