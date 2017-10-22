<?php
/* Enter your code here. Read input from STDIN. Print output to STDOUT */
class Node{
  public $d; // array - distribution of chocolates
  public $parent;
  public $method; // structure - ['personNum'=>, 'addNum'=>]
  public function __contructor($d, $parent, $method){
    $this->d = $d;
    $this->parent = $parent;
    $this->method = $method;
  }
}
$methods = [1, 2, 5];
$stdin = fopen('php://stdin', 'r');
$testCnt = trim(fgets(STDIN)); // reads one line from STDIN

for($l = 0; $l<$testCnt; $l++) {
  $line = trim(fgets(STDIN));
  $line = trim(fgets(STDIN));
  calc(explode(' ', $line));
}

function calc($initDistribution){
  $n = new Node($initDistribution, null, null);
  $cache = [];
  $queue = [$n];
  $result = step();

  if ($result) {
    fwrite(STDOUT, 'foo');
  }
}

function step() {
  $n = array_pop($queue);
  $hash = createHash($n->d);
  if (isset($cache[$hash])) {
    // we already processed this case somewhere before in tree, skip it
    return false;
  }
  foreach($n->d as $person => $chNum){
    foreach($methods as $method){

      $nextDistribution = applyMethod($n->d, $method, $person);
      $n1 = new Node($nextDistribution, $n, ['personNum'=>$person, 'addNum'=>$method]);
      if (isFair($n1->d)) {
        // we found the shortetst way, calc its number
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
  return step();
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
