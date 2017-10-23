<?php
/* Enter your code here. Read input from STDIN. Print output to STDOUT */
class Node{
  public $d; // array - distribution of chocolates
  public $parent;
  public $method; // structure - ['personNum'=>, 'addNum'=>]
  public function __construct($d, $parent, $method){
    $this->d = $d;
    sort($this->d);
    $this->parent = $parent;
    $this->method = $method;
  }
}

class Process {
  private $methods = [1, 2, 5];
  private $debug = false;

  function setDebug($v){
    $this->debug = $v;
  }

  function run(){
    $testCnt = trim(fgets(STDIN)); // reads one line from STDIN

    $initDistributions = [];
    for($l = 0; $l<$testCnt; $l++) {
      $line = trim(fgets(STDIN));
      $line = trim(fgets(STDIN));

      $initDistribution = explode(' ', $line);
      $initDistribution = array_map(function($e){
        return (int)$e;
      }, $initDistribution);
      $initDistributions[] = $initDistribution;
    }

    $result = $this->calc($initDistributions);
    if ($result) {
      fwrite(STDOUT, implode("\n", $result));
    }
  }

  function calc($initDistributions){
    $results = [];
    foreach($initDistributions as $initDistribution) {
      $n = new Node($initDistribution, null, null);
      $cache = [];
      $queue = [$n];
      $results[] = $this->step($queue, $cache);
    }
    return $results;
  }

  function step($queue, $cache) {
    $this->log("queue ". var_export(count($queue), true));
    $msg = '';
    foreach ($queue as $e) {
      foreach ($e->d as $d) {
        $msg .= $d." ";
      }
      $msg .= ", ";
    }
    $this->log($msg);
    $this->log("cache ".var_export(count($cache), true));

    $n = array_pop($queue);
    $hash = $this->createHash($n->d);
    if (isset($cache[$hash])) {
      // we already processed this case somewhere before in tree, skip it
      $this->log("hash ".$hash." already processed\n");
      return $this->step($queue, $cache);
    } else {
      $cache[$hash] = true;
    }
    foreach($n->d as $person => $chNum){
      foreach($this->methods as $method){
        $nextDistribution = $this->applyMethod($n->d, $method, $person);
        $n1 = new Node($nextDistribution, $n, null);
        if ($this->isFair($n1->d)) {
          // we found the shortest way, calc its number
          $stepCount = 0;
          while($n1->parent !== null){
            $stepCount++;
            $n1 = $n1->parent;
          }
          return $stepCount;
        }
        array_unshift($queue, $n1);
      }
    }
    return $this->step($queue, $cache);
  }

  function createHash($distribution){
    $hash = '';
    foreach($distribution as $chNum){
      $hash .= "_".$chNum;
    }
    return $hash;
  }

  function isFair($distribution){
    foreach($distribution as $k => $d){
      if ($distribution[0] !== $d) return false;
    }
    return true;
  }

  function applyMethod($distribution, $method, $person){
    $r = [];
    foreach($distribution as $k => $chNum){
      if ($k !== $person){
        array_push($r, $chNum+$method);
      } else {
        array_push($r, $chNum);
      }
    }
    return $r;
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}