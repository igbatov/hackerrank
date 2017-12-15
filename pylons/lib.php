<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;
    private $towerCount = 0;
    private $cache = [];

    /**
     * @param $k
     * @param $cities
     * @return mixed
     */
    function p($k, $cities) {
        if (empty($cities)) {
            return 1;
        }
        // find first city that is the most far from begin and still can light all before him
        $firstLightCity = null;
        foreach ($cities as $city => $tower) {
            $tower = (int)$tower;
            if ($city <= $k && $tower) {
                $firstLightCity = $city;
            }
        }
        if ($firstLightCity === null) {
            return -1;
        }

        $this->towerCount++;
        $this->p($k, array_slice($cities, $firstLightCity+$k));
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    public function run($handle)
    {
        $n = null;
        $k = null;
        $cities = [];

        list ($n, $k) = $this->scanf($handle, "%d %d"); // $n - number of cities, $k - distance

        list ($str) = $this->scanf($handle, "%[^\n]");
        $cities = explode(' ', $str);

        $result = $this->p($k, $cities);
        return $result === -1 ? -1 : $this->towerCount;
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
