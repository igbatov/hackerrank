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

  function p($input_data){
    $n = array_shift($input_data);
    $ds = explode(' ',array_shift($input_data));
    $ds = array_map(function($item){
      return (int)$item;
    }, $ds);
    // glue numbers that has intersections in bits
    for ($i=0; $i<$n; $i++){
      for ($j=$i+1; $j<$n; $j++){
        if ($this->countBits($ds[$j]) > 1 && $this->countBits($ds[$i]) > 1 && $this->countBits($ds[$j]&$ds[$i]) != 0) {
          $ds[$j] = $ds[$j]|$ds[$i];
          unset($ds[$i]);
          break;
        }
      }
    }

    // for each independent connection component calc all sum
    $nodesInComponents = 0;
    $componentsCnt = 0;
    foreach ($ds as $d) {
      $nodesInComponents += $this->countBits($d);
      $componentsCnt++;
    }
    $componentsCnt += 64 - $nodesInComponents;

    return $componentsCnt;
  }

  function countBits($value){
    if (isset($this->cache[$value])){
      return $this->cache[$value];
    } else {
      $count = 0;
      while($value)
      {
        $count += ($value & 1);
        $value = $value >> 1;
      }
      $this->cache[$value] = $count;
      return $count;
    }
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}