<?php
    include __DIR__.'/lib.php';
    $p = new Process();
    $p->setDebug(true);
    $s = fopen('test_data/test1.txt', 'r');
    var_dump(2); echo ' must be ';  var_dump($p->run($s));
