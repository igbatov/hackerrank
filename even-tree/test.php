<?php
include('lib.php');
use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class ProcessTest extends TestCase
{
  public function testProcess()
  {
    $p = new Process();
    $p->setDebug(true);
    $s = '10 9
2 1
3 1
4 3
5 2
6 1
7 2
8 6
9 8
10 8';
    $this->assertEquals(2, $p->p(explode("\r\n", $s)));
  }
}