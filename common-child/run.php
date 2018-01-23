<?php
include('lib.php');
$p = new Process();
$p->setDebug(false);
$handle = fopen ("php://stdin","r");
fwrite(STDOUT, $p->run($handle));