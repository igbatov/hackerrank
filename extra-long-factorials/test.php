<?php
    include __DIR__.'/lib.php';
    $p = new Process();
    $p->setDebug(true);
    $s = fopen('test_data/test1.txt', 'r');
    var_dump($p->run($s)); echo ' must be '; var_dump('15511210043330985984000000');
//$a = $p->convertNumberToArray(11);
//$b = $p->convertNumberToArray(3628800);
//$r = $p->multiply($a, $b);
//$v = 1;

