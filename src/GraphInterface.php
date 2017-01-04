<?php
/**
 * Created by PhpStorm.
 * User: BlackScorp
 * Date: 04.01.2017
 * Time: 19:42
 */

namespace BlackScorp\Astar;


interface GraphInterface
{
    /**
     * @param Node $current
     * @return Node[]
     */
    public function getNeighbors(Node $current);
    /**
     * @param $x
     * @param $y
     * @return Node|false
     */
    public function getPoint($x, $y);
}