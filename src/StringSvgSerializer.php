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
        $buf = $this->getXmlHead();
        $visitor = new Visitor\AttributeStringVisitor();

        $stack = new \SplStack();
        $last_depth = 0;
        foreach (krak_svg_iter_top_down($svg) as $depth => $el) {
            $ws_prefix = str_repeat($this->indentation, $depth);

            // close tags
            while ($depth < $last_depth) {
                list($_depth, $_el) = $stack->pop();
                $buf .= $this->indent($_depth, "</".$el->getTagName().">\n");
                $last_depth = $_depth;
            }

            $last_depth = $depth;

            $buf .= $this->indent($depth, "<".$el->getTagName());

            $attrs = $visitor->visitElement($el);
            if ($attrs) {
                $buf .= ' ' . $attrs;
            }

            if (count($el->getChildren())) {
                $buf .= ">\n";
                $stack->push([$depth, $el]);
            }
            else if ($el->getTagName() == 'text' && $el->getText()) {
                $buf .= ">" . $el->getText() . "</text>\n";
            }
            else if ($el->getTagName() == 'defs') {
                $buf .= ">" . $el->getContent() . "</defs>\n";
            }
            else {
                $buf .= "/>\n";
            }
        }

        while ($stack->count()) {
            list($depth, $el) = $stack->pop();
            $buf .= $this->indent($depth, "</".$el->getTagName().">\n");
        }

        return $buf;
    }

    private function indent($depth, $str) {
        return str_repeat($this->indentation, $depth) . $str;
    }
}
