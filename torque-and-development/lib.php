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
      fwrite(STDOUT, $this->p($cities, $clib, $croad)."\n");
    }
  }

  function p($cities, $clib, $croad){
    if($croad>=$clib) {
      return count($cities)*$clib;
    }

    $available = [];

    $sum = 0;
    while(count($available) < count($cities)){
      $unavailable = array_diff(array_keys($cities), $available);
      $r = $this->getMinConnectRoads($unavailable[0], $cities);
      $sum += $clib + $croad*$r['roadsNum'];
      $available = array_merge($available, $r['passedCities']);
    }
    return $sum;
  }

  function getMinConnectRoads($city, $cities){
    $passedCities = [];
    $passedCities[$city] = true;
    $roadsNum = 0;
    $queue = [$city];
    while(count($queue) != 0){
      $c = array_pop($queue);
      foreach ($cities[$c] as $city) {
        if (!isset($passedCities[$city])){
          $roadsNum++;
          $passedCities[$city] = true;
          array_unshift($queue, $city);
        }
      }
    }
    return ['passedCities'=>$passedCities, 'roadsNum'=>$roadsNum];
  }

  function getAllConnectedCities($city, $cities){
    $oldC = [];
    $newC = [$city];
    while(count($oldC) != count($newC)){
      $oldC = $newC;
      foreach ($oldC as $c){
        $newC = array_merge($newC, $cities[$c]);
      }
      $newC = array_unique($newC);
    }
    return $newC;
  }

  function updateAvaliable($city, $cities, $available){
    $available[] = $city;
    $available = array_merge($available, $cities[$city]);
    return array_unique($available);
  }

  /**
   * Get city with most roads to cities that is still not in $available
   * @param $cities
   * @param $available
   * @return int|null|string
   */
  function getMaxIndentCity($cities, $available){
    if (empty($cities)) {
      return null;
    }

    $maxIndent = -1;
    $maxCity = null;
    foreach($cities as $city => $neibs){
      $cityIndent = count(array_diff($neibs, $available));
      if ($cityIndent > $maxIndent) {
        $maxIndent = $cityIndent;
        $maxCity = $city;
      }
    }
    return $maxCity;
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