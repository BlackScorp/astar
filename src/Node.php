<?php
namespace BlackScorp\Astar;

class Node
{
    private $x = 0;
    private $y = 0;
    private $costs = 0;
    private $visited = false;
    private $closed = false;
    private $parent = null;
    private $f = 0;
    private $h = 0;
    private $score = 0;
    public function __construct($y, $x, $costs)
    {
        $this->x = (int)$x;
        $this->y = (int)$y;
        $this->costs = (int)$costs;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $f
     */
    public function setF($f)
    {
        $this->f = $f;
    }


    /**
     * @param int $h
     */
    public function setH($h)
    {
        $this->h = $h;
    }

    public function visit(){
        $this->visited = true;
    }
    public function close(){
        $this->closed = true;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * @param Node $parent
     */
    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return int
     */
    public function getF()
    {
        return $this->f;
    }
    /**
     * @return int
     */
    public function getH()
    {
        return $this->h;
    }
    public function isClosed(){
        return $this->closed === true;
    }
    public function isVisited(){
        return $this->visited === true;
    }
}
