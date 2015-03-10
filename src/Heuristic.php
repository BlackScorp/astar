<?php
namespace BlackScorp\Astar;

class Heuristic {
     public static function factory($type){
         $class = '\\BlackScorp\\Astar\\Heuristic\\'.ucfirst($type);

        return new $class;
    }
}
