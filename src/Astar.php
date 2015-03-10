<?php

class Astar_Astar {

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
        $this->grid = $grid->nodes();
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

                while ($curr->parent) {
                    $result[] = $curr;
                    $curr = $curr->parent;
                }
                return array_reverse($result);
            }
            $current->closed = true;


            foreach ($this->neighbors($this->grid, $current) as $neighbor) {

                if ($neighbor->closed || in_array($neighbor->type, $this->blocked)) {
                    continue;
                }
                $score = $current->g + $neighbor->cost;
                $visited = $neighbor->visited;
                if (!$visited || $score < $neighbor->g) {
                    $neighbor->visited = TRUE;
                    $neighbor->parent = $current;
                    $neighbor->h = $this->heuristic->compare($neighbor, $end);
                    $neighbor->g = $score;
                    $neighbor->f = $neighbor->g + $neighbor->h;
                    if (!$visited) {
                        $heap->push($neighbor);
                    } else {
                        $heap->rescoreElement($neighbor);
                    }
                }
            }
        }

        return array();
    }

    private function neighbors(array $grid, Node $node) {
        $result = array();
        $x = $node->x;
        $y = $node->y;

        // West
        if (isset($grid[$y - 1]) && isset($grid[$y - 1][$x])) {
            $result[] = ($grid[$y - 1][$x]);
        }

        // East
        if (isset($grid[$y + 1]) && isset($grid[$y + 1][$x])) {
            $result[] = ($grid[$y + 1][$x]);
        }

        // South
        if (isset($grid[$y]) && isset($grid[$y][$x - 1])) {
            $result[] = ($grid[$y][$x - 1]);
        }

        // North
        if (isset($grid[$y]) && isset($grid[$y][$x + 1])) {
            $result[] = ($grid[$y][$x + 1]);
        }

        if ($this->diagonal) {

            // Southwest
            if (isset($grid[$y - 1]) && isset($grid[$y - 1][$x - 1])) {
                $result[] = ($grid[$y - 1][$x - 1]);
            }

            // Southeast
            if (isset($grid[$y + 1]) && isset($grid[$y + 1][$x - 1])) {
                $result[] = ($grid[$y + 1][$x - 1]);
            }

            // Northwest
            if (isset($grid[$y - 1]) && isset($grid[$y - 1][$x + 1])) {
                $result[] = ($grid[$y - 1][$x + 1]);
            }

            // Northeast
            if (isset($grid[$y + 1]) && isset($grid[$y + 1][$x + 1])) {
                $result[] = ($grid[$y + 1][$x + 1]);
            }
        }

        return $result;
    }

}
