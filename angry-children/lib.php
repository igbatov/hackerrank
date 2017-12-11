<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;
    private $cache = [];

    /**
     * @param $n
     * @param $k
     * @param $numbers
     * @return mixed
     */
    function p($n, $k, $numbers){
        // sort numbers
        $last = count($numbers)-1;
        $first = 0;
        sort($numbers);
        for ($i=0; $i<($n - $k); $i++) {
            // determine what to throw - first o last element
            if (($numbers[$last-1] - $numbers[$first]) < ($numbers[$last] - $numbers[$first+1])) {
                $last--;
            } else {
                $first++;
            }
        }

        return $numbers[$last] - $numbers[$first];
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    function run($handle)
    {
        $n = null;
        $k = null;
        $numbers = [];

        list ($n) = $this->scanf($handle, "%d"); // $n - number of elements
        list ($k) = $this->scanf($handle, "%d"); // $n - number of elements

        for ($i = 0; $i<$n; $i++) {
            list ($number) = $this->scanf($handle, "%d"); // $n - number of elements
            $numbers[] = (int)$number;
        }

        return $this->p($n, $k, $numbers);
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
