<?php
namespace BlackScorp\Astar\Graph;

use BlackScorp\Astar\GraphInterface;
use BlackScorp\Astar\Node;

class DiagonalTileGraph implements GraphInterface
{

    private $nodes = array();

    public function __construct($grid)
    {
        foreach ($grid as $y => $cols) {
            foreach ($cols as $x => $value) {
                $this->nodes[$y][$x] = new Node($x, $y, $value);
            }
        }
    }

    /**
     * @param $x
     * @param $y
     * @return Node|false
     */
    public function getPoint($x, $y)
    {
        return isset($this->nodes[$y][$x]) ? $this->nodes[$y][$x] : false;
    }

    /**
     * @param Node $node
     * @return Node[]
     */
    public function getNeighbors(Node $node)
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

            $neighbourLocations[] = [$y - 1, $x - 1];
            $neighbourLocations[] = [$y + 1, $x - 1];
            $neighbourLocations[] = [$y - 1, $x + 1];
            $neighbourLocations[] = [$y + 1, $x + 1];

        foreach ($neighbourLocations as $location) {
            list($y, $x) = $location;
            $node = $this->getPoint($x, $y);
            if ($node) {
                $result[] = $node;
            }

        }
        return $result;
    }
}