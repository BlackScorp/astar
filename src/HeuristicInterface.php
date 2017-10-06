<?php
namespace BlackScorp\Astar;

interface HeuristicInterface
{
    public function compare(Node $node, Node $goal);
}