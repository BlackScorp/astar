<?php
namespace BlackScorp\Astar;


class AstarHeap extends \SplHeap{
    /**
     * (PHP 5 &gt;= 5.3.0)<br/>
     * Compare elements in order to place them correctly in the heap while sifting up.
     * @link http://php.net/manual/en/splheap.compare.php
     * @param mixed $value1 <p>
     * The value of the first node being compared.
     * </p>
     * @param mixed $value2 <p>
     * The value of the second node being compared.
     * </p>
     * @return int Result of the comparison, positive integer if <i>value1</i> is greater than <i>value2</i>, 0 if they are equal, negative integer otherwise.
     * </p>
     * <p>
     * Having multiple elements with the same value in a Heap is not recommended. They will end up in an arbitrary relative position.
     */
    protected function compare($value1,$value2)
    {

        if($value1->getF() === $value2->getF()) return 0;
       return ($value1->getF() < $value2->getF())? -1 : 1 ;
    }

}