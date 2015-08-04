<?php

namespace Krak\Svg\Element;

function attr_iter_to_col($attrs)
{
    $map = [];
    foreach ($attrs as $key => $value) {
        $map[$key] = new SimpleAttribute($key, $value);
    }

    return new AttributeCollection($map);
}

function attr_image($im_data, $mimetype = 'image/png', $base_64 = true)
{
    $fmt = 'data:%s;%s';

    if ($base_64) {
        $im_data = 'base64,' . base64_encode($im_data);
    }

    return new SimpleAttribute('xlink:href', sprintf($fmt, $mimetype, $im_data));
}

function attr_simple_to_string(SimpleAttribute $attr)
{
    return sprintf('%s="%s"', $attr->getKey(), $attr->getValue());
}

function attr_transform_to_string(TransformAttribute $attr)
{
    $val = implode(' ', array_map(function($tuple)
    {
        return $tuple[0] . '(' . implode(' ', $tuple[1]) . ')';
    }, $attr->getTypes()));

    return sprintf('%s="%s"', $attr->getKey(), $val);
}
