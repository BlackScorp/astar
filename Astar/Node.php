<?php

class Astar_Node {

    private $data = array();

   
    public function __construct($y,$x,$type){
        $this->x = (int)$x;
        $this->y =(int) $y;
        $this->type = (int)$type;
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __get($name) {
        if(isset($this->data[$name])) return $this->data[$name];
    
        return false;
    }
}
