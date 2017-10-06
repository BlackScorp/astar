## A-Star

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BlackScorp/astar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/BlackScorp/astar/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/BlackScorp/astar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/BlackScorp/astar/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/BlackScorp/astar/badges/build.png?b=master)](https://scrutinizer-ci.com/g/BlackScorp/astar/build-status/master)

[A-star](https://en.wikipedia.org/wiki/A*_search_algorithm) is a path finding algorithm, written in PHP. 
It can find the shortest path between two points in a two dimensional array by using different heuristics.

## Installation

~~~
composer require blackscorp/astar
~~~

## Usage

first create a two dimensional array for your map
~~~php
  $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 1, 1],
            [0, 0, 0, 1, 0],
        ];
~~~
each key represent the x and y position of the map.
each value of the array represents the costs, A-star tries to find a way with lowest costs.
you can use negative keys if your map requires it.

next convert the array to a Grid, a Grid is a collection of Nodes.

~~~php
$grid = new BlackScorp\Astar\Grid($map);
~~~

now you can fetch nodes from the Grid like so

~~~php
$startPosition = $grid->getPoint(3,1);
$endPosition = $grid->getPoint(0,0);
~~~

at the end pass the grid to the astar and search for the shortests path

~~~php
$astar = new BlackScorp\Astar\Astar($grid);
$nodes = $astar->search($startPosition,$endPosition);
if(count($nodes) === 0){
   echo "Path not found";
}else{
  foreach($nodes as $node){
     echo $node->getY().'/'.$node->getX().'<br/>';
  }
}
~~~

## Settings

by default diagonal directions are disabled, they can be enabled like so

~~~php
$astar->enableDiagonal();
~~~

as soon as the diagonal option is enabled, the algorithm use the [Manhattan](http://theory.stanford.edu/~amitp/GameProgramming/Heuristics.html) heuristic to find the shortest path.

Manhattan is not precise but the caluclation costs are low, however you can use another heuristics like Diagonal or Euclidean with following code.

~~~php
$astar->setHeuristic(new BlackScorp\Astar\Heuristic\Euclidean());
~~~

you can also create a custom heuristic.

## Block locations

there are cases where you want to block a specific path completly, independant of the costs, you can do so with following code

~~~php
astar->blocked([3,2]);
~~~

this basicly means that in the initial map

~~~php
  $map = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 2, 2, 0, 0],
            [0, 3, 0, 1, 1],
            [0, 0, 0, 1, 0],
        ];
~~~

the values 3 and 2 cannot be passed.

## Contribute

Please feel free to make pull requests, there is still place for improvement, the Grid contains a two dimensional array which might be replaced by an SplFixedArray or something similar.

Run the tests to be sure nothing break.

