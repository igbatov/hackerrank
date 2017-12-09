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
    $s = '4 6
1 2 5
1 3 3
4 1 6
2 4 7
3 2 4
3 4 5';
    $this->assertEquals(12, $p->p(explode("\r\n", $s)));
  }
}