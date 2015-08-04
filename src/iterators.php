<?php

use Krak\Svg\Element\AbstractElement;

/**
 * @deprecated
 */
function krak_svg_iter_bottom_up(AbstractElement $root)
{
    return krak\svg\iter_bottom_up($root);
}

/**
 * @deprecated
 */
function krak_svg_iter_top_down(AbstractElement $root)
{
    return krak\svg\iter_top_down($root);
}
