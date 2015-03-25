<?php

use Krak\Svg\Element\AbstractElement;

function krak_svg_iter_bottom_up(AbstractElement $root)
{
    $create_tuple = function($root) {
        // stdclass because it needs to be a reference object
        $obj = new StdClass();
        $obj->el = $root;
        $obj->index = 0;
        return $obj;
    };

    $stack = new SplStack();
    $stack->push($create_tuple($root));

    while (count($stack)) {
        $top = $stack->top();
        $children = $top->el->getChildren();

        if ($top->index < count($children)) {
            $child = $children[$top->index];
            $stack->push($create_tuple($child));
            $top->index++;
        }
        else {
            yield $stack->count() - 1 => $top->el;
            $stack->pop();
        }
    }
}

function krak_svg_iter_top_down(AbstractElement $root)
{
    $create_tuple = function($root) {
        // stdclass because it needs to be a reference object
        $obj = new StdClass();
        $obj->el = $root;
        $obj->index = 0;
        return $obj;
    };

    $stack = new SplStack();
    $stack->push($create_tuple($root));

    while (count($stack)) {
        $top = $stack->top();
        $children = $top->el->getChildren();

        if ($top->index == 0) {
            yield $stack->count() - 1 => $top->el;
        }

        if ($top->index < count($children)) {
            $child = $children[$top->index];
            $stack->push($create_tuple($child));
            $top->index++;
        }
        else {
            $stack->pop();
        }
    }
}
