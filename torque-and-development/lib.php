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
    for($a0 = 0; $a0 < $q; $a0++){
      fscanf($handle, "%i %i %li %li", $n, $m, $clib, $croad);
      $cities = [];
      for($a1 = 0; $a1 < $m; $a1++){
        fscanf($handle, "%i %i", $city_1, $city_2);
        $cities[$city_1][] = $city_2;
        $cities[$city_2][] = $city_1;
      }
      fwrite(STDOUT, (float)$this->p($cities, $clib, $croad)."\n");
    }
  }

  function p($roads, $clib, $croad){
    if($croad == 0 && $croad>=$clib) {
      return count($roads)*$clib;
    }
    $cities = array_keys($roads);

    $unavailable = [];
    foreach ($cities as $city){
      $unavailable[$city] = true;
    }

    $sum = 0;
    while(count($unavailable)){
      $r = $this->getMinConnectRoads(array_keys($unavailable)[0], $roads);
      $sum += $clib + $croad*$r['roadsNum'];
      foreach ($r['passedCities'] as $city){
        unset($unavailable[$city]);
      }
    }
    return $sum;
  }

  function getMinConnectRoads($city, $roads){
    $passedCities = [];
    $passedCities[$city] = true;
    $roadsNum = 0;
    $queue = [$city];
    while(count($queue) != 0){
      $c = array_shift($queue);
      foreach ($roads[$c] as $city) {
        if (!isset($passedCities[$city])){
          $roadsNum++;
          $passedCities[$city] = true;
          $queue[] = $city;
        }
      }
    }
    return ['passedCities'=>array_keys($passedCities), 'roadsNum'=>$roadsNum];
  }

  function updateAvaliable($city, $cities, $available){
    $available[] = $city;
    $available = array_merge($available, $cities[$city]);
    return array_unique($available);
  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}