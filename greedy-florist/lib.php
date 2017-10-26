<?php
function getMinimumCost($n, $k, $c){
  sort($c);
  $sum=0;
  $cCnt = count($c);
  $iterCnt = 0;
  // Complete this function
  while($n>0){
    for($i=0; $i<$k; $i++){
      if ($n>0){
        $sum += ($iterCnt+1)*$c[$cCnt-1-$iterCnt*$k-$i];
        $n--;
      }
    }
    $iterCnt++;
  }
  return $sum;
}


