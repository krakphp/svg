<?php

use Krak\Svg\Element;

/**
 * @deprecated
 */
function krak_svg_iterable_to_attr_col($attributes)
{
    return element\attr_iter_to_col($attributes);
}

/**
 * @deprecated
 */
function krak_svg_image_attr($im_data, $mimetype = 'image/png', $base_64 = true)
{
    return element\attr_image($im_data, $mimetype, $base_64);
}
