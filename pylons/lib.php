<?php
class Process
{
  private $debug = false;

  function setDebug($v)
  {
    $this->debug = $v;
  }

  function run()
  {
    $nk = explode(' ', trim(fgets(STDIN))); // reads one line from STDIN
    $n = $nk[0];
    $k = $nk[1];
    $towers = explode(' ', trim(fgets(STDIN)));

  }

  function log($m){
    if (!$this->debug) {
      return false;
    }
    echo $m."\n";
    ob_flush();
  }
}