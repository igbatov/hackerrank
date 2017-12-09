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
    $s = '5 3
0 1
2 3
0 4';
    $this->assertEquals(6, $p->run($s));
  }
}