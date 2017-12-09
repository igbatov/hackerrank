<?php
class Node{
  public $id;
  public $childs; // array of ids
  public $depth; // int
  public $parent; // id

  public function __construct($id, $childs, $depth)
  {
    $this->id = $id;
    $this->childs = $childs;;
    $this->depth = $depth;
  }
}

/**
 * Class Process
 */
class Process
{
  private $debug = false;

  function cutBranch($nodes){
    // first with DFS find leaf
    $visited = [];
    $groupedByDepth = [0=>[$nodes[1]]];
    $queue = [$nodes[1]];
    while(!empty($queue)){
      $node = array_pop($queue);
      foreach ($nodes[$node->id]->childs as $childId){
        if(!isset($visited[$node->id])){
          $nodes[$childId]->depth = $node->depth + 1;
          $nodes[$childId]->parent = $node->id;
          array_unshift($queue, $nodes[$childId]);
          $groupedByDepth[$nodes[$childId]->depth][] = $nodes[$childId];
        }
      }
      $visited[$node->id] = true;
    }

    ksort($groupedByDepth);
    // ok, now get the most deep child and ascend recursively up
    // to parents until even number of nodes will be collected in branch
    $parent = array_pop($groupedByDepth)[0]->parent;
    while($parent != null){
      $parent = $nodes[$parent];
      if ($this->calcSubtreeNodes($parent, $nodes)%2 == 0){
        // we found branch to cut, return graph without this branch
        $nodes[$parent->parent]->childs = [];
        return [1, $nodes[1]];
      } else {
        $parent = $nodes[$parent->parent];
      }
    }
    // if we are here we cannot cut subtree with even number of nodes
    return $this->calcSubtreeNodes($parent, $nodes)%2 ? [0, $nodes[1]] : false;
  }

  /**
   * Calc number of nodes with BFS
   * @param $node
   * @return int
   */
  function calcSubtreeNodes($node, $nodes){
    $queue = [$node];
    $visited = [];
    $cnt = 1;
    while(count($queue)){
      $node = array_shift($queue);
      $visited[$node->id] = true;
      foreach ($node->childs as $childId){
        if (!isset($visited[$childId])){
          $cnt++;
          $queue[] = $nodes[$childId];
        }
      }
    }
    return $cnt;
  }

  function p($input_data){
    list($n, $m) = explode(' ', array_shift($input_data));
    $nodes = [];
    for ($i=0; $i<$m; $i++){
      list($a, $b) = explode(' ', array_shift($input_data));
      if(!isset($nodes[$a])){
        $nodes[$a] = new Node($a, [], null);
      }
      if(!isset($nodes[$b])){
        $nodes[$b] = new Node($b, [], null);
      }
      $nodes[$a]->childs[] = $b;
      $nodes[$b]->childs[] = $a;
    }
    $nodes[1]->depath = 0;
    $nodes[1]->parent = null;

    list($cuttedNodesNum, $newNodes) = $this->cutBranch($nodes);
    if ($cuttedNodesNum === false) {
      return false;
    }
    $sum = $cuttedNodesNum;
    while($sum > 0){
      list($cuttedNodesNum, $newNodes) = $this->cutBranch($newNodes);
      $sum++;
    }

    return $cuttedNodesNum;
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
