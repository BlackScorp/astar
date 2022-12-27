<?php
namespace BlackScorp\Astar;

class ScoreHeap extends \SplHeap
{
    /**
     * @param Node $value1
     * @param Node $value2
     * @return int
     */
    protected function compare($value1, $value2): int
    {

        if ($value1->getTotalScore() === $value2->getTotalScore()) {
            return 0;
        }
        return ($value1->getTotalScore() < $value2->getTotalScore()) ? 1 : -1;
    }
}
