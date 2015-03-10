<?php
namespace BlackScorp\Astar;

class Graph {

    private $nodes = array();

    public function __construct($grid) {

        foreach ($grid as $y => $cols) {
            foreach ($cols as $x => $value) {
                $this->nodes[$y][$x] = new Node($y, $x, $value);
                $node = $this->nodes[$y][$x];
                $node->f = 0;
                $node->g = 0;
                $node->h = 0;
                $node->cost = (int) $node->type;
                $node->visited = false;
                $node->closed = false;
                $node->parent = null;
            }
        }
    }

    public function nodes() {
        return $this->nodes;
    }

    public function node($x = NULL, $y = NULL) {
        if (isset($this->nodes[$y][$x]))
            return $this->nodes[$y][$x];
        return false;
    }

}
