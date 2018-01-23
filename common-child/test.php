<?php
    include __DIR__.'/lib.php';
    $p = new Process();
    $p->setDebug(true);

    $s = fopen('test_data/test1.txt', 'r');
    var_dump($p->run($s)); echo ' must be '; var_dump("2");
//
//    $s = fopen('test_data/test2.txt', 'r');
//    var_dump($p->run($s)); echo ' must be '; var_dump("0");
//
//    $s = fopen('test_data/test3.txt', 'r');
//    var_dump($p->run($s)); echo ' must be '; var_dump("3");
//
//    $s = fopen('test_data/test4.txt', 'r');
//    var_dump($p->run($s)); echo ' must be '; var_dump("2");
