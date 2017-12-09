<?php

/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];

  function setDebug($v)
  {
    $this->debug = $v;
  }

  function run()
  {
    $input_data = file_get_contents("php://stdin");
    fwrite(STDOUT, $this->p($input_data));
  }

  /**
   *
   * @param $edges
   * @param $firstNode
   */
  function getDijkstraTree($edges, $firstNode)
  {
    $queue = [];
    $visited = []; // store for all calculated nodes
    $this->addToQueue($queue, $firstNode, 0);
    $minTree = [$firstNode=>[]];
    $parents = [$firstNode => null];
    while(count($queue) != 0){
      // choose minimal node
      $node = $this->getMinNode($queue);
      $visited[$node] = $queue[$node];
      unset($queue[$node]);
      foreach ($edges[$node] as $to => $w){
        if(isset($visited[$to])){
          continue;
        }
        if($this->addToQueue($queue, $to, $visited[$node] + $w)){
          if (isset($parents[$to]) && isset($minTree[$parents[$to]]) && isset($minTree[$parents[$to]][$to])) {
            unset($minTree[$parents[$to]][$to]);
          }
          $parents[$to] = $node;
          $minTree[$node][$to] = true;
        };
      }
    }
    return [$minTree, $visited];
  }

  function p($input_data){
    list($n, $m) = explode(' ', array_shift($input_data));
    $edges = [];
    for ($i=0; $i<$m; $i++){
      list($a, $b, $w) = explode(' ', array_shift($input_data));
      if ($i == 0) {
        $firstNode = $a;
      }
      $edges[$a][$b] = (int)$w;
      $edges[$b][$a] = (int)$w;
    }

    list($minTree, $visited) = $this->getDijkstraTree($edges, $firstNode);

    // calc overall weight with BFS
    $queue = [$firstNode];
    $sum = 0;
    while (count($queue) != 0) {
      $node = array_pop($queue);
      if(!isset($minTree[$node])){
        // if it is leaf - skip
        continue;
      }
      foreach ($minTree[$node] as $child){
        // add to queue
        array_unshift($queue, $child);

        $sum += $edges[$node][$child];
      }
    }

    return $sum;
  }

  function addToQueue(&$queue, $node, $w)
  {
    if (!isset($queue[$node]) || $queue[$node]>$w){
      $queue[$node] = $w;
      return true;
    }

    return false;
  }

  function getMinNode(&$queue)
  {
    $minW = INF;
    $minNode = null;
    foreach ($queue as $node => $w){
      if($w<$minW){
        $minNode = $node;
        $minW = $w;
      }
    }
    return $minNode;
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}
