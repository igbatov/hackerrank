<?php

/**
 * Class Process
 */
class Process
{
  private $debug = false;
  private $cache = [];
  const VECTOR_LENGTH = 64;
  const VECTORS_ARRAY_MAX_NUM = 20;


  /**
   * @param $selection - what vectors to take (in binary form)
   * @param $vectors
   * @return int
   */
  function p($selection, $vectors){
  }

  /**
   * Read from STDIN to initial structure
   * $handle = fopen ("php://stdin","r") | string;
   */
  function run($handle)
  {
    $n = null;

    list ($n, $k) = $this->scanf($handle,"%d %d"); // $n - number of elements
    $str = $this->scanf($handle,"%[^\n]")[0];
    $numbers = explode(' ', $str);

    // delete all numbers by $k
    $residuals = [];
    foreach ($numbers as $i=>$number) {
      $residuals[$number%$k][] = $i;
    }

    for ($i = 0; $i <$k; $i++) {
      if ($i === 0 && isset($residuals[$i])) {
        $residuals[$i] = [reset($residuals[$i])];
      } else {
        if (isset($residuals[$i]) && isset($residuals[$k-$i])) {
          if (count($residuals[$i]) > count($residuals[$k - $i])) {
            unset($residuals[$k - $i]);
          } else {
            unset($residuals[$i]);
          }
        }
      }
    }

    $elCnt = 0;
    foreach ($residuals as $residual) {
      $elCnt += count($residual);
    }

    return $elCnt;
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
