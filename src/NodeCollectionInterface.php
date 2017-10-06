<?php
/**
 * Created by PhpStorm.
 * User: BlackScorp
 * Date: 06.10.2017
 * Time: 17:27
 */

namespace BlackScorp\Astar;


interface NodeCollectionInterface
{
    /**
     * @param Node $node
     * @param bool $diagonal
     * @return Node[]
     */
    public function getNeighbors(Node $node, $diagonal = false);
}