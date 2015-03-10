<?php

class Astar_Heap {

    private $nodes = array();
 
   

    public function score(Node $n) {
        return $n->f;
    }
 
    public function push(Node $n) {
        $this->nodes[] = $n;
        $this->sink_down($this->size() - 1);
    }

    public function pop() {
        $result = $this->nodes[0];
        $end = array_pop($this->nodes);
         
        if ($this->size() > 0) {
            $this->nodes[0] = $end;
            $this->bubble_up(0);
        }
   
                
        return $result;
    }

    public function remove($node) {
        $i = $this->index($node);
        $end = array_pop($this->nodes);
      
        if ($i !== $this->size() - 1) {
            $this->nodes[$i] = $end;
            if ($this->score($end) < $this->score($node)) {
                $this->sink_down($i);
            } else {
                $this->bubble_up($i);
            }
        }
    }

    public function size() {
        return count($this->nodes);
    }

    private function index(Node $n) {
        foreach ($this->nodes as $i => $node) {
            if ($n === $node){
                echo $i;
                    return $i;
            }
            
        }
    }

    public function rescore_element(Node $n) {
        $this->sink_down($this->index($n));
    }

    private function sink_down($n) {
        $element = $this->nodes[$n];
        while ($n > 0) {
            $parentN = (($n + 1) >> 1) - 1;
          
            $parent = $this->nodes[$parentN];
            if ($this->score($element) < $this->score($parent)) {
                $this->nodes[$parentN] = $element;
                $this->nodes[$n] = $parent;
                $n = $parentN;
            } else {
                break;
            }
        }
    }

    private function bubble_up($n) {
        $len = $this->size();
        $element = $this->nodes[$n];
        $elementScore = $this->score($element);
        while (true) {
            $child2N = ($n + 1) << 1;
            $child1N = $child2N - 1;
            $swap = NULL;
            if ($child1N < $len) {
                $child1 = $this->nodes[$child1N];
                $child1Score = $this->score($child1);
                if ($child1Score < $elementScore)
                    $swap = $child1N;
            }
            if ($child2N < $len) {
                $child2 = $this->nodes[$child2N];
                $child2Score = $this->score($child2);
                if ($child2Score < ($swap === NULL ? $elementScore : $child1Score))
                    $swap = $child2N;
            }
            if ($swap !== NULL) {
                $this->nodes[$n] = $this->nodes[$swap];
                $this->nodes[$swap] = $element;
                $n = $swap;
            } else {
                break;
            }
        }
    }

}
