<?php

class Node {
  public $parent; // int
  public $id; // int
}

class Component {
  public $root; // implements Node
  public $childs=[]; // array of nodes
}

/**
 * Class Process
 */
class Process
{
  private $debug = false;

  function getKruskalTree($edgeList, $allNodesNum){
    ksort($edgeList);
    $comp = new Component();
    $components = [$comp];
    foreach ($edgeList as $w => $edges){
      foreach ($edges as $edge){
        $componentToJoin = null;

      }
    }
  }

  function addEdgeToComponent($component, $edge){
    if($this->inComponent($edge[0], $component)){
      $component->childs[$edge[1]];
    } else if($this->inComponent($edge[1], $component)){
      $component->childs[$edge[0]];
    }
  }

  function joinComponents($component1, $component2){

  }

  function inComponent(Node $node,  $component){
    return $component->root == $node->parent || isset($component->childs[$node->parent]);
  }

  function setDebug($v)
  {
    $this->debug = $v;
  }

  function run()
  {
    $input_data = file_get_contents("php://stdin");
    fwrite(STDOUT, $this->p($input_data));
  }

  function p($input_data){
    list($n, $m) = explode(' ', array_shift($input_data));
    $edges = [];
    for ($i=0; $i<$m; $i++){
      list($a, $b, $w) = explode(' ', array_shift($input_data));
      $edges[$w][] = [$a, $b];
    }

    list($minTree, $sum) = $this->getKruskalTree($edges);

    return $sum;
  }

  function getKruskalTree1($edgeList, $allNodesNum){
    ksort($edgeList);
    $components = [[]];
    $sum = 0;
    $nodesNum = 0;
    foreach ($edgeList as $w => $edges){
      foreach ($edges as $edge){
        $componentToJoin = null;
        foreach ($components as $i => $component){
          if (
          (isset($component[$edge[0]]) || isset($component[$edge[1]]))
          && !(isset($component[$edge[0]]) && isset($component[$edge[1]]))
          ) {
            $component[$edge[0]] = true;
            $component[$edge[1]] = true;
            $sum += $w;
            $nodesNum++;
            if ($nodesNum == $allNodesNum) {
              return $sum;
            }
            if(!$componentToJoin){
              $componentToJoin = $i;
            } else {
              $components[$componentToJoin] = array_merge($components[$i], $component);
              unset($components[$i]);
            }
          }
        }
      }
    }

    return [$components, $sum];
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}
