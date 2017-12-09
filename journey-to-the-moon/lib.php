<?php

/**
 * Class Process
 */
class Process
{
  private $debug = false;

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
    $s = explode(' ', array_shift($input_data));
    $n = $s[0];
    $k = $s[1];
    $pairs = [];
    $connComp = [];
    for($i=0; $i<$k; $i++) {
      $pair = explode(' ', trim($input_data));
      $pairs[$pair[0]][] = $pair[1];
      $pairs[$pair[1]][] = $pair[0];
      if ($pair[0]<$pair[1]) {
        $connComp[$pair[0]][] = $pair[0];
        $connComp[$pair[0]][] = $pair[1];
      } else {
        $connComp[$pair[1]][] = $pair[1];
        $connComp[$pair[1]][] = $pair[0];
      }
    }

    while(count($pairs)){
      foreach ($connComp as $i => $comp) {
        if (isset($pairs[$comp])) {
          $connComp[$i][] = $pairs[$comp];
          unset($pairs[$comp]);
        }
      }
    }

    // now calc number of pairs from different countries
    $sum = 0;
    foreach ($connComp as $i => $comp) {
      $sum += count($comp)*($n - count($comp));
    }

    return $sum;
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}