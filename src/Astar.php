<?php
namespace BlackScorp\Astar;

use BlackScorp\Astar\Heuristic\Manhattan;

class Astar
{

    private $diagonal = FALSE;
    private $blocked = array();
    /**
     * @var HeuristicInterface
     */
    private $heuristic = null;
    private $grid = null;


    public function blocked(array $types)
    {
        $this->blocked = $types;
        return $this;
    }

    public function diagonal($diagonal)
    {
        $this->diagonal = $diagonal;
        return $this;
    }

    public function __construct(Graph $grid)
    {
        $this->grid = $grid;
        return $this;
    }

    public function setHeuristic(HeuristicInterface $heuristic)
    {
        $this->heuristic = $heuristic;
    }

    public function search(Node $start, Node $end)
    {

        if (!$this->heuristic)
            $this->setHeuristic(new Manhattan());
        
        $astarHeap = new AstarHeap();
        $astarHeap->insert($start);

        while ($astarHeap->valid()) {
            $current = $astarHeap->current();
            if ($current === $end) {

                $result = array();
                $curr = $current;

                while ($curr->getParent()) {
                    $result[] = $curr;
                    $curr = $curr->getParent();
                }
                return array_reverse($result);
            }
            $current->close();
            $neighbors = $this->grid->getNeighbors($current, $this->diagonal);
            foreach ($neighbors as $neighbor) {
                if ($neighbor->isClosed() || in_array($neighbor->getCosts(), $this->blocked)) {
                    continue;
                }
                $score = $current->getG() + $neighbor->getCosts();
                $visited = $neighbor->isVisited();
                if (!$visited || $score < $neighbor->getG()) {

                    $neighbor->visit();
                    $neighbor->setParent($current);
                    $neighbor->setH($this->heuristic->compare($neighbor, $end));
                    $neighbor->setG($score);
                    $neighbor->setF($neighbor->getG() + $neighbor->getH());
                    if (!$visited) {
                        $astarHeap->insert($neighbor);
                    }
                }

            }

            $astarHeap->next();
        }

        return array();
    }

}
