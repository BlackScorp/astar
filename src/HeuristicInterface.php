<?php
namespace BlackScorp\Astar;

interface HeuristicInterface {
    public function compare(Node $n0, Node $n1);
}