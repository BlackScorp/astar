<?php
namespace BlackScorp\Astar\Heuristic;

use BlackScorp\Astar\HeuristicInterface;
use BlackScorp\Astar\Node;

class Diagonal implements HeuristicInterface
{
    public function compare(Node $node, Node $goal)
    {

        $deltaX = abs($node->getX() - $goal->getX());
        $deltaY = abs($node->getY() - $goal->getY());
        return max($deltaX, $deltaY);
    }
}