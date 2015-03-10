<?php
namespace BlackScorp\Astar\Heuristic;
use BlackScorp\Astar\Node;

class Manhattan {

    public function compare(Node $n0, Node $n1) {
  
        $d1 = abs($n1->x - $n0->x);
        $d2 = abs($n1->y - $n0->y);
        return $d1 + $d2;
    }

}