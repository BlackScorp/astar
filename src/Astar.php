<?php
namespace BlackScorp\Astar;

class Astar {

    private $diagonal = FALSE;
    private $blocked = array();
    private $heuristic = NULL;
    private $grid = array();

    const MANHATTAN = 'manhattan';
    const DIAGONAL = 'diagonal';

    public function blocked(array $types) {
        $this->blocked = $types;
        return $this;
    }

    public function diagonal($diagonal) {
        $this->diagonal = $diagonal;
        return $this;
    }

    public function heuristic($heuristic) {
        $this->heuristic = Heuristic::factory($heuristic);
        return $this;
    }

    public function __construct(Graph $grid) {
        $this->grid = $grid;
        return $this;
    }

    public function search(Node $start, Node $end) {

        if (!$this->heuristic)
            $this->heuristic(Astar::MANHATTAN);

        $heap = new Heap();
        $heap->push($start);


        while ($heap->size() > 0) {

            $current = $heap->pop();
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



            foreach ($this->grid->getNeighbors($current,$this->diagonal) as $neighbor) {

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
                    $neighbor->setF( $neighbor->getG() + $neighbor->getH());

                    if (!$visited) {
                        $heap->push($neighbor);
                    } else {
                        $heap->rescore_element($neighbor);
                    }
                }
            }
        }

        return array();
    }

}
