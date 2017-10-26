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
    $n = trim(fgets(STDIN)); // reads one line from STDIN
    for($i=0; $i<$n; $i++) {
      trim(fgets(STDIN));
      $B = explode(' ', trim(fgets(STDIN)));
      fwrite(STDOUT, $this->p($B)."\n");
    }
  }

  function p($B){
    if (count($B) < 2) return 0;
    $max = $this->getNextMax(0, 0, $B[0], $B[1]);
    $maxUp = $max['up'];
    $maxDown = $max['down'];
    for($i=1;$i<count($B)-1;$i++){
      $max = $this->getNextMax($maxUp, $maxDown, $B[$i], $B[$i+1]);
      $maxUp = $max['up'];
      $maxDown = $max['down'];
    }
    return max($maxUp, $maxDown);
  }

  function getNextMax($maxUp, $maxDown, $Bi, $Bii)
  {
    $newMaxUp = max($maxUp + abs($Bi-$Bii), $maxDown + abs(1-$Bii));
    $newMaxDown = max($maxUp + abs($Bi-1), $maxDown + abs(1-1));
    return ['up' => $newMaxUp, 'down' => $newMaxDown];
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}