<?php
include('../lib/deijkstra.php');
use PHPUnit\Framework\TestCase;

final class ProcessTest extends TestCase
{
  public function testProcess()
  {
    $p = new Process();
    $p->setDebug(true);
    $s = '4 4
1 2 24
1 4 20
3 1 3
4 3 12
1
';
    $this->assertEquals('0 24 3 15'."\n", implode(' ', $p->run($s)));
  }
}