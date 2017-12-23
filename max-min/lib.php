<?php

class DisjointSet{
  private $p; // connect each node with its set representative node
  private $rank; // rank of each set representative node

  public function addSet($id){
    if(isset($this->p[$id])){
      throw new Exception($id.' already in set');
    }
    $this->p[$id] = $id;
    $this->rank[$id] = 0;
    return true;
  }

  public function findSet($id){
    if (!isset($this->p[$id])){
      throw new Exception($id.' is not in set');
    }

    $p = $this->p[$id];
    while($p !== $this->p[$p]){
      $p = $this->p[$p];
    }

    return $p;
  }

  public function joinSets($id1, $id2){
    if (!isset($this->p[$id1]) || !isset($this->p[$id1])){
      throw new Exception('Both ids should be in some set');
    }

    $p1 = $this->findSet($id1);
    $p2 = $this->findSet($id2);

    if($p1 === $p2) {
      // already in one set
      return;
    }

    if($this->rank[$p1] === $this->rank[$p2]){
      $this->rank[$p2]++;
    }

    if($this->rank[$p1] < $this->rank[$p2]){
      $this->p[$p1] = $p2;
      unset($this->rank[$p1]);
    } else {
      $this->p[$p2] = $p1;
      unset($this->rank[$p2]);
    }
  }

  public function getSetsCount()
  {
    return count($this->rank);
  }
}

/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];
  const VECTOR_LENGTH = 64;
  const VECTORS_ARRAY_MAX_NUM = 20;

  function shiftRight($n, $i){
    while($i>0){
      $i--;
      $n = $n/2;
    }
    return $n;
  }

  function testBit($n, $i){
    return gmp_testbit (gmp_init($n), $i);
  }

  function toBin($n){
    $str = '';
    for($i=0; $i<64; $i++){
      if($this->testBit($n, $i)) {
        $str .= '1';
      } else {
        $str .= '0';
      }
    }
    return strrev($str);
  }

  /**
   * @param $selection - what vectors to take (in binary form)
   * @param $vectors
   * @return int
   */
  function p($selection, $vectors){
    // create subset of $vectors according to $selection
    $subset = [];
    for($i=0; $i<self::VECTORS_ARRAY_MAX_NUM; $i++) {
      if ($this->testBit($selection, $i)) {
        $subset[] = $vectors[$i];
      }
    }

    $ds = $this->initDisjoint();

    for($j = 0; $j < count($subset); $j++){
      $vector = $subset[$j];
      $firstId = null;
      for($i=0; $i<64; $i++){
        if($this->testBit($vector, $i)) {
          $firstId = $i;
          break;
        }
      }

      for($k=$i+1; $k<64; $k++){
        if($this->testBit($vector, $k)) {
          $ds->joinSets($firstId, $k);
        }
      }
    }

    return $ds->getSetsCount();
  }

  /**
   * Read from STDIN to initial structure
   * $handle = fopen ("php://stdin","r") | string;
   */
  function run($handle)
  {
    $n = null;
    $a = null;
    $b = null;

    list ($n) = $this->scanf($handle,"%d"); // $n - number of elements

    $str = $this->scanf($handle,"%[^\n]")[0];
    $vectors = explode(' ', $str);

    $num = 0;
    for ($i = 0; $i<pow(2, $n); $i++) {
      $num += $this->p($i, $vectors);
    }

    return $num;
  }

  function initDisjoint()
  {
    $ds = new DisjointSet();
    for($i=0; $i<self::VECTOR_LENGTH; $i++){
      $ds->addSet($i);
    }
    return $ds;
  }

  function scanf(&$handle, $format)
  {
    if (is_resource($handle)) {
      return fscanf($handle, $format);
    } else {
      $r = sscanf($handle, $format);
      $ar = explode("\r\n", $handle);
      $handle = substr($handle, strlen($ar[0])+2);
      return $r;
    }
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
