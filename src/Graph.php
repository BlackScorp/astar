<?php
namespace BlackScorp\Astar;

class Graph
{

    private $nodes = array();

    public function __construct($grid)
    {

        foreach ($grid as $y => $cols) {
            foreach ($cols as $x => $value) {
                $this->nodes[$y][$x] = new Node($y, $x, $value);
            }
        }
    }

    public function nodes()
    {
        return $this->nodes;
    }

    public function node($y, $x)
    {
        return isset($this->nodes[$y][$x])?$this->nodes[$y][$x]:false;
    }

    /**
     * @param Node $node
     * @param bool $diagonal
     * @return Node[]
     */
    public function getNeighbors(Node $node, $diagonal = false)
    {
        $result = array();
        $x = $node->getX();
        $y = $node->getY();

        // West
        if (isset($this->nodes[$y - 1]) && isset($this->nodes[$y - 1][$x])) {
            $result[] = ($this->nodes[$y - 1][$x]);
        }

        // East
        if (isset($this->nodes[$y + 1]) && isset($this->nodes[$y + 1][$x])) {
            $result[] = ($this->nodes[$y + 1][$x]);
        }

        // South
        if (isset($this->nodes[$y]) && isset($this->nodes[$y][$x - 1])) {
            $result[] = ($this->nodes[$y][$x - 1]);
        }

        // North
        if (isset($this->nodes[$y]) && isset($this->nodes[$y][$x + 1])) {
            $result[] = ($this->nodes[$y][$x + 1]);
        }

        if ($diagonal) {

            // Southwest
            if (isset($this->nodes[$y - 1]) && isset($this->nodes[$y - 1][$x - 1])) {
                $result[] = ($this->nodes[$y - 1][$x - 1]);
            }

            // Southeast
            if (isset($this->nodes[$y + 1]) && isset($this->nodes[$y + 1][$x - 1])) {
                $result[] = ($this->nodes[$y + 1][$x - 1]);
            }

            // Northwest
            if (isset($this->nodes[$y - 1]) && isset($this->nodes[$y - 1][$x + 1])) {
                $result[] = ($this->nodes[$y - 1][$x + 1]);
            }

            // Northeast
            if (isset($this->nodes[$y + 1]) && isset($this->nodes[$y + 1][$x + 1])) {
                $result[] = ($this->nodes[$y + 1][$x + 1]);
            }
        }

        return $result;
    }

}
