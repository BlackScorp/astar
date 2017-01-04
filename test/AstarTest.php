<?php
use BlackScorp\Astar\Astar;
use BlackScorp\Astar\Grid;
use BlackScorp\Astar\Heuristic\Diagonal;
use BlackScorp\Astar\Heuristic\Euclidean;

require_once __DIR__ . '/../vendor/autoload.php';

class AstarTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Grid
     */
    private $map = null;
    /**
     * @var Astar
     */
    private $astar = null;

    public function setUp()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 1, 1],
            [0, 0, 0, 1, 0],
        ];
        $this->map = new Grid($map);
        $this->astar = new Astar($this->map);
    }

    public function testSimplePath()
    {
        $start = $this->map->getPoint(0, 0);
        $end = $this->map->getPoint(1, 1);
        $result = $this->astar->search($start, $end);
        $this->assertSame(3, count($result));
    }

    public function testSimpleDiagonalPath()
    {
        $start = $this->map->getPoint(0, 0);
        $end = $this->map->getPoint(1, 1);
        $this->astar->enableDiagonal();
        $result = $this->astar->search($start, $end);
        $this->assertSame(2, count($result));
    }

    public function testUnreachablePath()
    {
        $start = $this->map->getPoint(0, 0);
        $end = $this->map->getPoint(4, 4);
        $this->astar->blocked(array(1));
        $result = $this->astar->search($start, $end);
        $this->assertEmpty($result);
    }

    public function testDiagonalHeuristic()
    {
        $start = $this->map->getPoint(0, 0);
        $end = $this->map->getPoint(4, 3);
        $this->astar->setHeuristic(new Diagonal());
        $result = $this->astar->search($start, $end);
        $this->assertSame(8, count($result));
    }

    public function testEuclideanHeuristic()
    {
        $start = $this->map->getPoint(0, 0);
        $end = $this->map->getPoint(4, 3);
        $this->astar->setHeuristic(new Euclidean());
        $result = $this->astar->search($start, $end);
        $this->assertSame(8, count($result));
    }

    public function testIssue2()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 2, 2, 0, 0],
            [0, 3, 0, 1, 1],
            [0, 0, 0, 1, 0],
        ];
        $grid = new Grid($map);
        $astar = new Astar($grid);
        $astar->blocked([3, 2]);
        $startPosition = $grid->getPoint(2,3);
        $endPosition = $grid->getPoint(0, 0);
        $result = $astar->search($startPosition, $endPosition);
        $actualValues = [];
        $expectedValues = [
            '2-3',
            '1-3',
            '0-3',
            '0-2',
            '0-1',
            '0-0',
        ];
        foreach ($result as $node) {
            $actualValues[] = sprintf('%d-%d', $node->getY(), $node->getX());
        }
        $this->assertSame($expectedValues,$actualValues);
    }
}
