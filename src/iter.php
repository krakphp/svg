<?php

namespace Krak\Svg;

use SplStack;

function iter_bottom_up(Element\AbstractElement $root)
{
    $stack = new SplStack();
    $stack->push(new IterTuple($root));

    while (count($stack)) {
        $top = $stack->top();
        $children = $top->el->getChildren();

        if ($top->index < count($children)) {
            $child = $children[$top->index];
            $stack->push(new IterTuple($child));
            $top->inc();
        }
        else {
            yield $stack->count() - 1 => $top->el;
            $stack->pop();
        }
    }
}

function iter_top_down(Element\AbstractElement $root)
{
    $stack = new SplStack();
    $stack->push(new IterTuple($root));

    while (count($stack)) {
        $top = $stack->top();
        $children = $top->el->getChildren();

        if ($top->index == 0) {
            yield $stack->count() - 1 => $top->el;
        }

        if ($top->index < count($children)) {
            $child = $children[$top->index];
            $stack->push(new IterTuple($child));
            $top->inc();
        }
        else {
            $stack->pop();
        }
    }
}

/**
 * Simple Tuple class used to keep track of the stack when iterating
 */
class IterTuple
{
    public $el;
    public $index;

    public function __construct($el, $index = 0)
    {
        $this->el = $el;
        $this->index = $index;
    }

    public function inc()
    {
        $this->index++;
    }
}
