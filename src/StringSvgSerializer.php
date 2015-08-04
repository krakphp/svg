<?php

namespace Krak\Svg;

use Closure,
    SplStack;

class StringSvgSerializer implements SvgSerializer
{
    private $show_doctype;
    private $indentation;

    public function __construct($show_doctype = true, $indentation_level = 2)
    {
        $this->show_doctype = $show_doctype;
        $this->indentation = str_repeat(" ", $indentation_level);
    }

    private function getXmlHead()
    {
        if (!$this->show_doctype) {
            return '';
        }

        $q_mark = '?';
        $xml_head = '<'.$q_mark.'xml version="1.0" encoding="utf-8"'.$q_mark.'>' . PHP_EOL . '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . PHP_EOL;

        return $xml_head;
    }

    public function serializeSvg(Element\Svg $svg)
    {
        $start_buf = $this->getXmlHead();
        $end_buf = '';
        $visitor = new Visitor\AttributeStringVisitor();

        $fmt = "%s<%s";
        $end_fmt = "%s</%s>\n";
        foreach (krak_svg_iter_top_down($svg) as $depth => $el) {
            $ws_prefix = str_repeat($this->indentation, $depth);

            $start_buf .= sprintf(
                $fmt,
                $ws_prefix,
                $el->getTagName()
            );

            $attrs = $visitor->visitElement($el);
            if ($attrs) {
                $start_buf .= ' ' . $attrs;
            }

            if (count($el->getChildren())) {
                $start_buf .= ">\n";
                $end_buf = sprintf($end_fmt, $ws_prefix, $el->getTagName()) . $end_buf;
            }
            else if ($el->getTagName() == 'text' && $el->getText()) {
                $start_buf .= ">" . $el->getText() . "</text>\n";
            }
            else {
                $start_buf .= "/>\n";
            }
        }

        return $start_buf . $end_buf;
    }
}
