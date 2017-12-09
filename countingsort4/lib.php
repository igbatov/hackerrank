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
    $handle = fopen ("php://stdin", "r");
    fscanf($handle, "%i",$q);
    for($i = 0; $i < $q; $i++){
      fscanf($handle, "%i %s", $n, $s);
      $k = 100*$n;
      while(isset($array[$k])){
        $k++;
      }
      if ($i >= $q/2) {
        $array[$k] = $array[$k] + $s + " ";
      } else {
        $array[$k] = $array[$k] + '-' + " ";
      }
    }
    foreach ($array as $item) {
      fwrite(STDOUT, implode(' ', $item));
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