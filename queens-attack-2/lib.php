<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;

    public function p($n, $queen, $obstacles)
    {
        // add corners as obstacles
        $obstacles[] = [-1, -1];
        $obstacles[] = [-1, $n+1];
        $obstacles[] = [$n+1, $n+1];
        $obstacles[] = [$n+1, -1];

        // move $queen to the (0, 0)
        foreach ($obstacles as $i => $obstacle) {
            $obstacles[$i][0] -= $queen[0];
            $obstacles[$i][1] -= $queen[1];
        }

        // calc obstacles that lies on diagonals or axes
        $obstDistances = [$n, $n, $n, $n, $n]; // indexed from top-left half-diagonal to bottom-right, clockwise
        foreach ($obstacles as $i => $obstacle) {
            if ($obstacle[0] < 0 && $obstacle[1] > 0 && abs($obstacle[0]) === abs($obstacle[1])) {
                // means it lies diagonal in first quadrant diag, calculate distance to zero
                if ($obstacle[1] - 2 < $obstDistances[0]) {
                    $obstDistances[0] = $obstacle[1] - 2;
                }
            }
            if ($obstacle[1] > 0 && $obstacle[0] === 0) {
                // means it lies on up axes, calculate distance to zero
                if ($obstacle[1] - 2 < $obstDistances[1]) {
                    $obstDistances[1] = $obstacle[1] - 2;
                }
            }
            if ($obstacle[0] > 0 && $obstacle[1] > 0 && abs($obstacle[0]) === abs($obstacle[1])) {
                // means it lies diagonal in second quadrant diagonal, calculate distance to zero
                if ($obstacle[1] - 2 < $obstDistances[2]) {
                    $obstDistances[2] = $obstacle[1] - 2;
                }
            }
            if ($obstacle[0] > 0 && $obstacle[1] === 0) {
                // means it lies diagonal on right axes, calculate distance to zero
                if ($obstacle[0] - 2 < $obstDistances[3]) {
                    $obstDistances[3] = $obstacle[0] - 2;
                }
            }
            if ($obstacle[0] > 0 && $obstacle[1] < 0 && abs($obstacle[0]) === abs($obstacle[1])) {
                // means it lies diagonal on right axes, calculate distance to zero
                if (abs($obstacle[0]) - 2 < $obstDistances[4]) {
                    $obstDistances[4] = abs($obstacle[0]) - 2;
                }
            }
            if ($obstacle[0] === 0 && $obstacle[1] < 0) {
                // means it lies diagonal on right axes, calculate distance to zero
                if (abs($obstacle[1]) - 2 < $obstDistances[5]) {
                    $obstDistances[5] = abs($obstacle[1]) - 2;
                }
            }
            if ($obstacle[0] < 0 && $obstacle[1] < 0 && abs($obstacle[0]) === abs($obstacle[1])) {
                // means it lies diagonal on right axes, calculate distance to zero
                if (abs($obstacle[0]) - 2 < $obstDistances[6]) {
                    $obstDistances[6] = abs($obstacle[0]) - 2;
                }
            }
            if ($obstacle[0] < 0 && $obstacle[1] === 0) {
                // means it lies diagonal on right axes, calculate distance to zero
                if (abs($obstacle[1]) - 2 < $obstDistances[6]) {
                    $obstDistances[6] = abs($obstacle[1]) - 2;
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
        list ($qx, $qy) = $this->scanf($handle, "%d %d");
        $obstacles = [];
        for ($i=0; $i<$k; $i++) {
            list ($x, $y) = $this->scanf($handle, "%d %d");
            $obstacles[] = [$x, $y];
        }
        return $this->p($n, [$qx, $qy], $obstacles);
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
