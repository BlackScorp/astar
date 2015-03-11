<?php
use BlackScorp\Astar\Astar;
use BlackScorp\Astar\Grid;
use BlackScorp\Astar\Heuristic\Diagonal;

require_once __DIR__.'/../vendor/autoload.php';
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

    public function setUp(){
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
        $start = $this->map->getPoint(0,0);
        $end = $this->map->getPoint(0,1);
        $result = $this->astar->search($start,$end);
        $this->assertSame(1, count($result));
    }

    public function testEmptyPath()
    {
        $start = $this->map->getPoint(0,0);
        $end = $this->map->getPoint(4,4);
        $this->astar->blocked(array(1));
        $result = $this->astar->search($start,$end);
        $this->assertEmpty($result);
    }

    public function testDiagonalPath()
    {
        $start = $this->map->getPoint(0,0);
        $end = $this->map->getPoint(1,1);
        $this->astar->diagonal(true);
        $result = $this->astar->search($start,$end);
        $this->assertSame(1, count($result));
    }

    public function testDiagonalHeuristic()
    {
        $start = $this->map->getPoint(0,0);
        $end = $this->map->getPoint(4,3);
        $this->astar->setHeuristic(new Diagonal());
        $result = $this->astar->search($start,$end);
        $this->assertSame(7, count($result));
    }
}
