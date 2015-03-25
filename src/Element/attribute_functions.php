<?php

use Krak\Svg\Element\AttributeCollection,
    Krak\Svg\Element\SimpleAttribute;

function krak_svg_iterable_to_attr_col($attributes)
{
    $col = new AttributeCollection();
    foreach ($attributes as $key => $value) {
        $col->setAttribute(new SimpleAttribute($key, $value));
    }

    return $col;
}

function krak_svg_image_attr($im_data, $mimetype = 'image/png', $base_64 = true)
{
    $fmt = 'data:%s;%s';

    if ($base_64) {
        $im_data = 'base64,' . base64_encode($im_data);
    }

    return new SimpleAttribute('xlink:href', sprintf($fmt, $mimetype, $im_data));
}
