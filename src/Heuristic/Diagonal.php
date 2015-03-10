<?php
namespace BlackScorp\Astar\Heuristic;
use BlackScorp\Astar\HeuristicInterface;
use BlackScorp\Astar\Node;

class Diagonal implements HeuristicInterface{

     public function compare(Node $n0, Node $n1) {

         $d1 = abs($n1->getX() - $n0->getX());
         $d2 = abs($n1->getY() - $n0->getY());
        return max($d1,$d2);
    }

}
