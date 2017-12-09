<?php

//class Process{
//  function setDebug($v){
//
//  }
//
//  function run($handle){
//    return [];
//  }
//
//
//}
class Node {
  public $id;
  public $pathWeight; // weight of shortest path from first node to this
  public $parent; // parent of short path

  public function __construct($id, $pathWeight, $parent)
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

  function p($edges, $nodes, $firstNodeId){
    $queue = new PriorityQueue();
    $visited = []; // contains finally process nodes
    $queue->add($nodes[$firstNodeId], 0);
    while($queue->count()){
      /** @var Node $parent */
      $parent = $queue->getMin();
      $queue->remove($parent->id);
      $visited[$parent->id] = $parent->pathWeight;
      foreach ($edges[$parent->id] as $childId => $weight){
        /** @var Node $n */
        $n = $queue->get($childId);
        if (!$n || $n && $n->pathWeight > $weight + $parent->pathWeight){
          $nodes[$childId]->parent = $parent;
          $nodes[$childId]->pathWeight = $weight + $parent->pathWeight;
          $queue->add($nodes[$childId], $weight + $parent->pathWeight);
        }
      }
    }

    return $nodes;
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
    for($a1 = 0; $a1 < $m; $a1++){
      list( $a, $b, $w) = $this->scanf($handle,"%d %d %d"); // nodeFrom.id, nodeTo.id, weight
      if (!isset($edges[$a])) $edges[$a] = [];
      if (!isset($nodes[$a])) {
        $nodes[$a] = new Node($a, INF, null);
      }
      if (!isset($edges[$b])) $edges[$b] = [];
      if (!isset($nodes[$b])) {
        $nodes[$b] = new Node($b, INF, null);
      }
      $edges[$a][$b] = $w;
      $edges[$b][$a] = $w;
    }
    list($firstNodeId) = $this->scanf($handle,"%d");
    $nodes[$firstNodeId]->pathWeight = 0;

    $nodes = $this->p($edges, $nodes, $firstNodeId);
    $weights = [];
    foreach ($nodes as $node){
      $weights[] = $node->pathWeight;
    }
    return $weights;
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
