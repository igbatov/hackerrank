<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;

    public function p($s)
    {
        $cnt = 0;
        $l = strlen($s);
        for ($i=1; $i<=$l; $i++) {
            for ($j=0; $j <= $l - $i; $j++) {
                $ethSubstr = $this->sortString(substr($s, $j, $i)); // ethalon substring
                for ($k=$j+1; $k <= $l - $i; $k++) {
                    $substr = substr($s, $k, $i);
                    if ($ethSubstr === $this->sortString($substr)) {
                        $cnt++;
                    }
                }
            }
        }

        return $cnt;
    }

    private function sortString($string)
    {
        $stringParts = str_split($string);
        sort($stringParts);
        return implode('', $stringParts);
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    public function run($handle)
    {
        $n = null;

        list ($n) = $this->scanf($handle, "%d");
        $cntList = [];
        for ($i=0; $i<$n; $i++) {
            list ($s) = $this->scanf($handle, "%s");
            $cntList[] = $this->p($s);
        }
        return implode("\n", $cntList);
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
