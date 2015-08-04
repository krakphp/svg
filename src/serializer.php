<?php

namespace Krak\Svg;

function serialize_svg($serializer, AbstractElement $root)
{
    if ($serializer instanceof SvgSerializer) {
        return $serializer->serializeSvg($root);
    }
    else if ($serializer instanceof \Closure) {
        return $serializer($root);
    }
    else if (is_callable($serializer)) {
        call_user_func($serializer, $root);
    }
}
