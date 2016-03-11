<?php
namespace BlackScorp\Astar;

class Grid
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
    /**
     * @param $y
     * @param $x
     * @return Node | false
     */
    public function getPoint($y, $x)
    {
        return isset($this->nodes[$y][$x]) ? $this->nodes[$y][$x] : false;
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

        $neighbourLocations = [
            [$y - 1, $x],
            [$y + 1, $x],
            [$y, $x - 1],
            [$y, $x + 1]
        ];
        if ($diagonal) {
            $neighbourLocations[] = [$y - 1, $x - 1];
            $neighbourLocations[] = [$y + 1, $x - 1];
            $neighbourLocations[] = [$y - 1, $x + 1];
            $neighbourLocations[] = [$y + 1, $x + 1];
        }
        foreach ($neighbourLocations as $location) {
            list($y, $x) = $location;
            $node = $this->getPoint($y, $x);
            if ($node) {
                $result[] = $node;
            }

        }
        return $result;
    }
}