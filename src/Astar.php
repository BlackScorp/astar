<?php
namespace BlackScorp\Astar;

use BlackScorp\Astar\Heuristic\Manhattan;

class Astar
{

    private $diagonal = false;
    private $blocked = array();
    /**
     * @var HeuristicInterface
     */
    private $heuristic = null;
    private $nodeCollection = null;


    public function blocked(array $types)
    {
        $this->blocked = $types;
    }

    public function enableDiagonal()
    {
        $this->diagonal = true;
    }

    public function __construct(NodeCollectionInterface $nodeCollection)
    {
        $this->nodeCollection = $nodeCollection;
    }

    public function setHeuristic(HeuristicInterface $heuristic)
    {
        $this->heuristic = $heuristic;
    }

    /**
     * @param Node $start
     * @param Node $end
     * @return Node[]
     */
    public function search(Node $start, Node $end)
    {

        if (!$this->heuristic) {
            $this->setHeuristic(new Manhattan());
        }

        $heap = new ScoreHeap();
        $heap->insert($start);

        $current = $this->fillHeap($heap, $start, $end);
        if ($current !== $end) {
            return [];
        }

        return $this->getReversedPath($current);

    }

    /**
     * @param Node $end
     * @param $heap
     * @param $current
     * @return Node
     */
    private function fillHeap(\SplHeap $heap, Node $current, Node $end)
    {
        while ($heap->valid() && $current !== $end) {
            /**
             * @var Node $current
             */
            $current = $heap->extract();

            $current->close();
            $neighbors = $this->nodeCollection->getNeighbors($current, $this->diagonal);
            foreach ($neighbors as $neighbor) {
                if ($neighbor->isClosed() || in_array($neighbor->getCosts(), $this->blocked)) {
                    continue;
                }
                $score = $current->getScore() + $neighbor->getCosts();
                $visited = $neighbor->isVisited();
                if (!$visited || $score < $neighbor->getScore()) {
                    $neighbor->visit();
                    $neighbor->setParent($current);
                    $neighbor->setGuessedScore($this->heuristic->compare($neighbor, $end));
                    $neighbor->setScore($score);
                    $neighbor->setTotalScore($neighbor->getScore() + $neighbor->getGuessedScore());
                    if (!$visited) {
                        $heap->insert($neighbor);
                    }
                }

            }
        }
        return $current;
    }

    /**
     * @param Node $current
     * @return array
     */
    private function getReversedPath(Node $current)
    {
        $result = [];
        while ($current->getParent()) {
            $result[] = $current;
            $current = $current->getParent();
        }
        $result[]=$current;
        return array_reverse($result);
    }
}