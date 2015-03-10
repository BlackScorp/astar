<?php

class Astar_Heuristic {
     public static function factory($type){
        $class = 'Astar_Heuristic_'.ucfirst($type);
        return new $class;
    }
}
