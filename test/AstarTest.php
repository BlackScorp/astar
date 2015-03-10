<?php

class AstarTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {


    }

    public function testSimplePath()
    {
        $map = [
            0 => [1, 1, 1, 1, 1],
            1 => [1, 0, 0, 0, 1],
            2 => [1, 0, 0, 0, 1],
            3 => [1, 0, 0, 0, 1],
            4 => [1, 1, 1, 1, 1],
        ];
        $graph = new \BlackScorp\Astar\Graph($map);
        $start_node = $graph->node(1, 1);
        $end_node = $graph->node(1,2);
        $astar = new \BlackScorp\Astar\Astar($graph);
        $result = $astar->search($start_node, $end_node);
        $this->assertSame(1,count($result));
    }
 
}
