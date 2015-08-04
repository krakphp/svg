# Svg

Krak Svg is a library for creating and exporting svg.

## Installation

````json
{
    "require": {
        "krak/svg": "^0.2"
    }
}
````

## Design & Usage

The Svg library is broken up into several components: Visitors, Iterators, Serializers, and Element.

### Building an Svg Tree

````php
<?php
$svg = new Krak\Svg\Element\Svg();
$svg->getAttributes()
    ->setWidth(320)
    ->setHeight(320)
    ->setXmlns('http://www.w3.org/2000/svg')
    ->setAttribute(
        new Krak\Element\SimpleAttribute(
            'xmlns:xlink',
            'http://www.w3.org/1999/xlink'
        )
    );

$group = new Krak\Svg\Element\Group();

$transform_attr = new Krak\Svg\Element\TransformAttribute();
$transform_attr->translate(30, 20);
$group->getAttributes()->setAttribute($transform_attr);

$rect = new Krak\Svg\Element\Rect();
$rect->setAttributes(krak\svg\element\attr_iter_to_col([
        'width' => 80,
        'height' => 80,
        'x' => 0,
        'y' => 0,
        'fill' => '#ffffff',
    ]));

$group->appendChild($rect);

$imagick = new Imagick('file.jpg');
$image = new Krak\Svg\Element\Image();
$image->getAttributes()
    ->setAttribute(
        krak_svg_image_attr(
            $imagick->getImageBlob(),
            'image/jpeg',
            true // base64 decode
        )
    )
    ->setX(0)
    ->setY(0);

$svg->appendChild($group);
$svg->appendChild($image);
````

### Serializing an Svg Tree

````php
<?php
$string_serializer = new Krak\Svg\StringSvgSerializer();
$png_serializer = new Krak\Svg\RsvgCliSvgSerializer($string_serializer);

$svg_string_data = $string_serializer->serializeSvg($svg);
$svg_png_data = $png_serializer->serializeSvg($svg);
````

The StringSerializer will export the tree into svg tree.

The RsvgCliSvgSerializer uses the `rsvg` command line utility to export an svg to a png, pdf, ps or any other format supported by rsvg. This serializer requires a string serializer thought to convert it to a string first.

### Iteratoring an Svg Tree

````php
<?php
foreach (krak\svg\iter_top_down($svg) as $depth => $el) {
    // ...
}
foreach (krak\svg\iter_bottom_up($svg) as $depth => $el) {
    // ...
}
/* the following are just aliases of what's above */
foreach (new Krak\Svg\TopDownIterator($svg) as $depth => $el) {
    // ..
}
foreach (new Krak\Svg\BottomUpIterator($svg) as $depth => $el) {
    // ..
}
````

We currently support to types of iterators: Top down and bottom up. The functional iterators are implemented as generators traversing the svg tree iteratively (as apposed to recursively). The iterator classes are just wrappers around the functional iterator generators.

- **Top Down**: Starts from the top of the tree and outputs on the way down.
- **Bottom Up**: Starts from the bottom of the tree and prints the lowest nodes first and works it's way up.

### Element Model

The element model is made up of Elements and Attributes. Each Element as an `AttributeCollection` which can hold Attributes. Most attributes are just SimpleAttriutes, but there are some special attributes that can be created and set per element.

Elements can also have hints which are just meta data associated with an element.

### Visitors and Walkers

Visitors and walkers are a way for modifying the svg tree before serializing it.

- **AttributeString Visitor**: Converts an elements attributes into a string
- **HeightCalculator Visitor**: Calculates the height of an svg element by summing the height of all of it's child elements. It only applies height calculation on elements with the query hint of `Krak\Svg\Visitor\HeightCalculatorVisitor::HINT` value.
