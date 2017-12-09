<?php
class Node {
  public $id;
  public $weight;
  public $parent;
}

/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];

  function getMinPathWArray($edges, $firstId) {
    ksort($edges);
    $visited = []; // nodes that already has its final min path weight
    $queue = [];
    $n = new Node();
    $n->id = $firstId;
    $n->weight = 0;
    $queue[] = $n;
    while (!empty($queue)) {
      $node = $this->getMinFromQueue($queue);
      $visited[$node->id] = $node->weight;
      foreach ($edges[$node->id] as $child) {
        if (!isset($visited[$child['to']])) {
          $this->addToQueue($queue, $child['to'], $node, $node->weight + $child['w']);
        }
      }
    }

    ksort($visited);
    return $visited;
  }

  function addToQueue(&$queue, $nodeId, $parent, $weight){
    foreach ($queue as $n){
      if($n->id === $nodeId){
        if ($n->weight > $weight){
          $n->parent = $parent;
          $n->weight = $weight;
        }
        return;
      }
    }
    $n = new Node();
    $n->id = $nodeId;
    $n->parent = $parent;
    $n->weight = $weight;
    array_unshift($queue, $n);
  }

  function getMinFromQueue(&$queue){
    $min = INF;
    $minNode = null;
    foreach ($queue as $node){
      if ($node->weight < $min) {
        $min = $node->weight;
        $minNode = $node;
      }
    }

    foreach ($queue as $i => $node){
      if ($node->id === $minNode->id){
        unset($queue[$i]);
      }
    }

    return $minNode;
  }

  function p($input_data){
    $str = '';
    $n = array_shift($input_data);
    // loop on number of tests
    for ($i=0; $i<$n; $i++){
      $nm = explode(' ',array_shift($input_data));
      $edges = [];
      for ($j=0; $j<$nm[1]; $j++){
        $abw = explode(' ',array_shift($input_data));
        $edges[$abw[0]][] = ['to'=>$abw[1], 'w'=>$abw[2]];
        $edges[$abw[1]][] = ['to'=>$abw[0], 'w'=>$abw[2]];
      }
      $firstNodeId = array_shift($input_data);
      $arr = array_values($this->getMinPathWArray($edges, $firstNodeId));
      array_shift($arr);
      $str .= implode(' ', $arr)."\n";
    }

    return $str;
  }

  function setDebug($v)
  {
    $this->debug = $v;
  }

  function run()
  {
    $input_data = [];
    $handle = fopen ("php://stdin","r");
    fscanf($handle,"%d",$t);
    $input_data[] = $t;
    for($a0 = 0; $a0 < $t; $a0++){
      fscanf($handle,"%d %d",$n,$m);
      $input_data[] = sprintf("%d %d",$n,$m);
      for($a1 = 0; $a1 < $m; $a1++){
        fscanf($handle,"%d %d %d",$x,$y,$r);
        $input_data[] = sprintf("%d %d %d",$x,$y,$r);
      }
      fscanf($handle,"%d",$s);
      $input_data[] = $s;
    }

    fwrite(STDOUT, $this->p($input_data));
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}