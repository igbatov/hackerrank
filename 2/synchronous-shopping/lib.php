<?php

class Node {
  public $id;
  public $pathWeight; // weight of shortest path from first node to this
  public $parent; // parent of short path

  public function __construct($id, $pathWeight=null, $parent=null)
  {
    $this->id = $id;
    $this->pathWeight = $pathWeight;
    $this->parent = $parent;
  }
}

/**
 * Constant time priority queue
 * Class PriorityQueue
 */
class PriorityQueue{
  private $queue = []; // assoc by element id
  private $queueByWeight = []; // assoc by element weight
  private $minWeight = INF;
  private $count = 0;

  function get($elementId){
    return isset($this->queue[$elementId]) ? $this->queue[$elementId]['element'] : null;
  }

  function remove($elementId){
    if (!isset($this->queue[$elementId])) {
      return;
    }
    unset($this->queueByWeight[$this->queue[$elementId]['weight']][$elementId]);
    if (empty($this->queueByWeight[$this->queue[$elementId]['weight']])){
      unset($this->queueByWeight[$this->queue[$elementId]['weight']]);
      $weights = array_keys($this->queueByWeight);
      $this->minWeight = empty($weights) ? INF : $weights[0];
    }
    unset($this->queue[$elementId]);
    $this->count--;
  }

  function add($element, $weight){
    if (!isset($this->queue[$element->id])) {
      $this->count++;
    }
    if ($weight < $this->minWeight) {
      $this->minWeight = $weight;
    }
    // remove it from old weight if any
    $this->remove($element->id);
    $this->queue[$element->id] = ['element'=>$element, 'weight'=>$weight];
    $this->queueByWeight[$weight][$element->id] = true;
  }

  /**
   * return Node
   */
  function getMin(){
    return $this->queue[array_keys($this->queueByWeight[$this->minWeight])[0]]['element'];
  }

  function count(){
    return $this->count;
  }
}
/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];

  function p($edges, $nodes){
    // get all connected component nodes
    $ccomponents = [];
    while(!empty($nodes)){
      $node = array_pop($nodes);
      if (!isset($edges[$node->id])){
        $ccomponents[] = [$node];
      } else {
        $queue = [$node];
        $visited = [];
        while(!empty($queue)){
          $lastElement = array_pop($queue);
          $visited[$lastElement->id] = true;
          foreach ($edges[$lastElement->id] as $nodeId => $w){
            if(!isset($visited[$nodeId])){
              array_unshift($queue, $nodes[$nodeId]);
              unset($nodes[$nodeId]);
            }
          }
        }
        $ccomponents[] = $visited;
      }
    }

    $num = 0;
    while(count($ccomponents) > 1){
      $cNum = count(array_pop($ccomponents));
      foreach ($ccomponents as $ccomponent){
        $num += $cNum*count($ccomponent);
      }
    }
    // overall number of possible pair
    return $num;
  }

  /**
   * Read from STDIN to initial structure
   * $handle = fopen ("php://stdin","r") | string;
   */
  function run($handle)
  {
    // structures to fill
    $edges = [];
    $nodes = [];
    $n = null;
    $m = null;
    $a = null;
    $b = null;
    $w = null;
    $firstNodeId = null;
    list ($n, $m) = $this->scanf($handle,"%d %d"); // $n - number of nodes, $m - number of edges

    for($a1 = 0; $a1 < $n; $a1++){
      $nodes[$a1] = new Node($a1);
    }

    for($a1 = 0; $a1 < $m; $a1++){
      list( $a, $b) = $this->scanf($handle,"%d %d"); // nodeFrom.id, nodeTo.id, weight
      if (!isset($edges[$a])) $edges[$a] = [];
      if (!isset($edges[$b])) $edges[$b] = [];
      $edges[$a][$b] = 0;
      $edges[$b][$a] = 0;
    }

    $num = $this->p($edges, $nodes);

    return $num;
  }

  function scanf(&$handle, $format)
  {
    if (is_resource($handle)) {
      return fscanf($handle, $format);
    } else {
      $ar = explode("\r\n", $handle);
      $r = sscanf($handle, $format);
      $handle = substr($handle, strlen($ar[0])+2);
      return $r;
    }
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }


  function setDebug($v)
  {
    $this->debug = $v;
  }
}
