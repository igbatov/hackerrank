<?php

/**
 * Class Process
 */
class Process
{
    private $debug = false;

    /**
     * Multiply two numbers that is stored in form of array.
     * p = [n => digit]; n is a pow, digit from 0 to 9
     * @param $p1
     * @param $p2
     * @return mixed
     */
    public function multiply($p1, $p2) {
        $resultP = [];
        if (count($p1) < count($p2)) {
            $tmp = $p1;
            $p1 = $p2;
            $p2 = $tmp;
        }
        foreach ($p1 as $pow1 => $digit1) {
            foreach ($p2 as $pow2 => $digit2) {
                $highDigit = floor($digit1*$digit2/10);
                $lowDigit = ($digit1*$digit2)%10;


                if ($highDigit){
                    $i = 1;
                    if (!isset($resultP[$pow1 + $pow2 + $i])) {
                        $resultP[$pow1 + $pow2 + $i] = 0;
                    }
                    while($resultP[$pow1 + $pow2 + $i] + $highDigit > 9) {
                        $tmp = $resultP[$pow1 + $pow2 + $i] + $highDigit;
                        $resultP[$pow1 + $pow2 + $i] = $tmp % 10;
                        $highDigit = floor($tmp / 10);
                        $i++;
                        if (!isset($resultP[$pow1 + $pow2 + $i])) {
                            $resultP[$pow1 + $pow2 + $i] = 0;
                        }
                    }
                    $resultP[$pow1 + $pow2 + $i] += $highDigit;
                }

                $i = 0;
                if (!isset($resultP[$pow1 + $pow2 + $i])) {
                    $resultP[$pow1 + $pow2 + $i] = 0;
                }
                while($resultP[$pow1 + $pow2 + $i] + $lowDigit > 9) {
                    $tmp = $resultP[$pow1 + $pow2 + $i] + $lowDigit;
                    $resultP[$pow1 + $pow2 + $i] = $tmp % 10;
                    $lowDigit = floor($tmp / 10);
                    $i++;
                    if (!isset($resultP[$pow1 + $pow2 + $i])) {
                        $resultP[$pow1 + $pow2 + $i] = 0;
                    }
                }
                $resultP[$pow1 + $pow2 + $i] += $lowDigit;
            }
        }

        return $resultP;
    }

    public function convertNumberToArray($number)
    {
        $i = 0;
        $p[$i] = $number%10;
        $t = floor($number/10);
        while ( $t>0 ) {
            $i++;
            $p[$i] = $t%10;
            $t = floor($t/10);
        }
        return $p;
    }

    /**
     * Read from STDIN to initial structure
     * $handle = fopen ("php://stdin","r") | string;
     */
    public function run($handle)
    {
        $n = null;

        list ($n) = $this->scanf($handle, "%d");
        $fibb = $this->convertNumberToArray(1);
        for ($i = 2; $i<=$n; $i++) {
            $fibb = $this->multiply($fibb, $this->convertNumberToArray($i));
        }

        ksort($fibb);
        return implode('', array_reverse($fibb));
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
