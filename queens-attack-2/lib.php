<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;

    public function p($n, $queen, $obstacles)
    {
      /**
       * we will operate on indefinite desk, so
       * add border obstacles
       */
      // left border
      for ($i=-1; $i<=$n; $i++) {
        $obstacles[] = [-1, $i];
      }
      // top border
      for ($i=-1; $i<=$n; $i++) {
        $obstacles[] = [$i, $n];
      }
      // right border
      for ($i=-1; $i<=$n; $i++) {
        $obstacles[] = [$n, $i];
      }
      // bottom border
      for ($i=-1; $i<=$n; $i++) {
        $obstacles[] = [$i, -1];
      }

      // move $queen to the (0, 0)
      foreach ($obstacles as $i => $obstacle) {
          $obstacles[$i][0] -= $queen[0];
          $obstacles[$i][1] -= $queen[1];
      }

      // calc obstacles that lies on diagonals or axes
      $obstDistances = [INF, INF, INF, INF, INF, INF, INF, INF]; // indexed from top-left half-diagonal to bottom-right, clockwise
      foreach ($obstacles as $i => $obstacle) {
          if ($obstacle[0] < 0 && $obstacle[1] > 0 && abs($obstacle[0]) === abs($obstacle[1])) {
              // means it lies diagonal in first quadrant diag, calculate distance to zero
              if ($obstacle[1] - 1 < $obstDistances[0]) {
                  $obstDistances[0] = $obstacle[1] - 1;
              }
          }
          if ($obstacle[1] > 0 && $obstacle[0] === 0) {
              // means it lies on up axes, calculate distance to zero
              if ($obstacle[1] - 1 < $obstDistances[1]) {
                  $obstDistances[1] = $obstacle[1] - 1;
              }
          }
          if ($obstacle[0] > 0 && $obstacle[1] > 0 && abs($obstacle[0]) === abs($obstacle[1])) {
              // means it lies diagonal in second quadrant diagonal, calculate distance to zero
              if ($obstacle[1] - 1 < $obstDistances[2]) {
                  $obstDistances[2] = $obstacle[1] - 1;
              }
          }
          if ($obstacle[0] > 0 && $obstacle[1] === 0) {
              // means it lies n right axes, calculate distance to zero
              if ($obstacle[0] - 1 < $obstDistances[3]) {
                  $obstDistances[3] = $obstacle[0] - 1;
              }
          }
          if ($obstacle[0] > 0 && $obstacle[1] < 0 && abs($obstacle[0]) === abs($obstacle[1])) {
              if (abs($obstacle[0]) - 1 < $obstDistances[4]) {
                  $obstDistances[4] = abs($obstacle[0]) - 1;
              }
          }
          if ($obstacle[0] === 0 && $obstacle[1] < 0) {
              if (abs($obstacle[1]) - 1 < $obstDistances[5]) {
                  $obstDistances[5] = abs($obstacle[1]) - 1;
              }
          }
          if ($obstacle[0] < 0 && $obstacle[1] < 0 && abs($obstacle[0]) === abs($obstacle[1])) {
              if (abs($obstacle[0]) - 1 < $obstDistances[6]) {
                  $obstDistances[6] = abs($obstacle[0]) - 1;
              }
          }
          if ($obstacle[0] < 0 && $obstacle[1] === 0) {
              if (abs($obstacle[0]) - 1 < $obstDistances[7]) {
                  $obstDistances[7] = abs($obstacle[0]) - 1;
              }
          }
        }

        $cells = 0;
        foreach ($obstDistances as $obstDistance) {
            $cells += $obstDistance;
        }
        return $cells;
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    public function run($handle)
    {
        $n = null;

        list ($n, $k) = $this->scanf($handle, "%d %d");
        list ($qy, $qx) = $this->scanf($handle, "%d %d");
        $obstacles = [];
        for ($i=0; $i<$k; $i++) {
            list ($y, $x) = $this->scanf($handle, "%d %d");
            $obstacles[] = [$x-1, $y-1]; // -1 because we want to count from zero
        }
        return $this->p($n, [$qx-1, $qy-1], $obstacles);
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
