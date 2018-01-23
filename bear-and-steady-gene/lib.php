<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;

    public function p($n, $s)
    {
        $mustBe = $n/4;
        $cnt = [];
        $s = str_split($s, 1);
        foreach ($s as $char){
            if (!isset($cnt[$char])) {
                $cnt[$char] = 0;
            }
            $cnt[$char]++;
        }

        $delta = [];
        foreach ($cnt as $char => $count) {
            if ($count - $mustBe > 0) {
                $delta[$char] = $count - $mustBe;
            }
        }

        $minLength = 0;
        foreach($delta as $count) {
            $minLength += $count;
        }

        if ($minLength === 0) {
            return 0;
        }

        // Find substring with number of chars as in $delta
        for ($i = $minLength; $i <= $n; $i++) {
            for ($j = 0; $j <= $n - $i; $j++) {
                if ($this->hasChars(array_slice($s, $j, $i), $delta)) {
                    return $i;
                }
            }
        }


        return $n;
    }

    /**
     * Check if $s has at least number of chars as in $delta
     * @param $s
     * @param $delta
     */
    private function hasChars($s, $delta) {
        $cnt = [];
        foreach ($s as $char){
            if (!isset($cnt[$char])) {
                $cnt[$char] = 0;
            }
            $cnt[$char]++;
        }

        foreach ($delta as $char => $count) {
            if ($cnt[$char] < $count) {
                return false;
            }
        }

        return true;
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    public function run($handle)
    {
        list ($n) = $this->scanf($handle, "%d");
        list ($s) = $this->scanf($handle, "%s");
        return $this->p($n, $s);
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
