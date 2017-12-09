<?php

/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];

  const BOARD_NUM = 100;
  const DICE_NUM = 6;

  /**
   * @param $start int
   * @param $snakes array
   * @param $ladders array
   */
  function getMinPathCnt($start, $snakes, $ladders)
  {
    if(isset($this->cache[$start])){
      return $start;
    }
    $this->cache[$start] = INF; // we want to skip oneself if we return to us in path search
    $minSubpath = INF;

    foreach ($this->getNextMoves($start, $snakes, $ladders) as $nextNode){

      if ($nextNode < self::BOARD_NUM){
        $m = $this->getMinPathCnt($nextNode, $snakes, $ladders);
      } else if ($nextNode === self::BOARD_NUM) {
        return 1;
      } else {
        return INF;
      }

      if ($m < $minSubpath) {
        $minSubpath = $m;
      }
    }
    $this->cache[$start] = 1+$minSubpath;
    return $this->cache[$start];
  }

  function getNextMoves($start, $snakes, $ladders){
    $nextNodes = [];
    for ($i=1; $i<self::DICE_NUM+1; $i++) {
      $nextNode = $start + $i;
      if (isset($snakes[$start + $i])) {
        $nextNode = $snakes[$start + $i];
      } elseif (isset($ladders[$start + $i])) {
        $nextNode = $ladders[$start + $i];
      }
      $nextNodes[] = $nextNode;
    }
    return $nextNodes;
  }

  function p($input_data){
    $n = array_shift($input_data);
    // loop on number of tests
    for ($i=0; $i<$n; $i++){
      $ds = explode(' ',array_shift($input_data));
      $snakes = [];
      for ($j=0; $j<$ds[0]; $j++){
        $sn = explode(' ',array_shift($input_data));
        $snakes[$sn[0]] = $sn[1];
      }
      $ladders = [];
      for ($j=0; $j<$ds[1]; $j++){
        $sn = explode(' ',array_shift($input_data));
        $ladders[$sn[0]] = $sn[1];
      }
      echo $this->getMinPathCnt(1, $snakes, $ladders);
    }
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

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}