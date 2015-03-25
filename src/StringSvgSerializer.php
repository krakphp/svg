<?php

namespace Krak\Svg;

use Closure,
    SplStack;

class StringSvgSerializer implements SvgSerializer
{
    private $show_doctype;
    public function __construct($show_doctype = true)
    {
        $this->show_doctype = $show_doctype;
    }

    private function popStack(SplStack $stack)
    {
        $top = $stack->pop();
        $depth = $stack->count();
        return str_repeat('  ', $depth) . '</'.$top->getTagName().">\n";
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

        $stack = new SplStack();
        $cur_depth = -1;
        $fmt = "%s<%s%s";
        foreach (krak_svg_iter_top_down($svg) as $depth => $el) {
            while ($cur_depth >= $depth) {
                $buf .= $this->popStack($stack);
                $cur_depth--;
            }

            $buf .= sprintf(
                $fmt,
                str_repeat("  ", $depth),
                $el->getTagName(),
                $visitor->visitElement($el)
            );

            if (count($el->getChildren())) {
                $stack->push($el);
                $buf .= ">\n";
                $cur_depth = $depth;
            }
            else if ($el->getTagName() == 'text' && $el->getText()) {
                $buf .= ">" . $el->getText() . "</text>\n";
                $cur_depth = $depth - 1;
            }
            else {
                $buf .= "/>\n";
                $cur_depth = $depth - 1; // this acts like we've just popped
            }
        }

        /* pop the rest off the stack */
        while (count($stack)) {
            $buf .= $this->popStack($stack);
        }

        return $buf;
    }
}
