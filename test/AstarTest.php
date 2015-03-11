<?php
require_once __DIR__.'/../vendor/autoload.php';
class AstarTest extends PHPUnit_Framework_TestCase
{

    public function testSimplePath()
    {
        $map = [
            [1, 1, 1, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 1, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(1, 1);
        $end_node = $graph->node(1, 2);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));

        $result = $astar->search($start_node, $end_node);

        $this->assertSame(1, count($result));
    }

    public function testEmptyPath()
    {
        $map = [
            [1, 1, 1, 1, 1],
            [1, 0, 1, 0, 1],
            [1, 1, 1, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 1, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(1, 1);
        $end_node = $graph->node(1, 3);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));

        $result = $astar->search($start_node, $end_node);

        $this->assertEmpty($result);
    }

    public function testRightBottomPath()
    {
        $map = [
            [1, 1, 1, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 1, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(1, 1);
        $end_node = $graph->node(2, 2);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));

        $result = $astar->search($start_node, $end_node);
        $this->assertSame(2, count($result));
    }

    public function testDiagonalPath()
    {
        $map = [
            [1, 1, 1, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 1, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(1, 1);
        $end_node = $graph->node(2, 2);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));
        $astar->diagonal(true);
        $result = $astar->search($start_node, $end_node);
        $this->assertSame(1, count($result));
    }

    public function testComplexDiagonalPath()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(0, 0);
        $end_node = $graph->node(4, 4);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));
        $astar->diagonal(true);
        $result = $astar->search($start_node, $end_node);
        $this->assertSame(5, count($result));
    }

    public function testComplexPath()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(0, 0);
        $end_node = $graph->node(4, 4);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));

        $result = $astar->search($start_node, $end_node);
        $this->assertSame(8, count($result));
    }

    public function testPathWithCosts()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [4, 1, 0, 1, 0],
            [0, 0, 0, 1, 0],
            [0, 1, 0, 0, 0],
            [0, 1, 0, 0, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(0, 0);
        $end_node = $graph->node(2, 0);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));
        $result = $astar->search($start_node, $end_node);

        $this->assertSame(6, count($result));
    }

    public function testDiagonalHeursitic()
    {
        $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(0, 0);
        $end_node = $graph->node(4, 4);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $astar->blocked(array(1));
        $astar->setHeuristic(new \BlackScorp\Astar\Heuristic\Diagonal());
        $result = $astar->search($start_node, $end_node);
        $this->assertSame(8, count($result));
    }
}
