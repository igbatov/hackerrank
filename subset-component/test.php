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
    $s = '3
2 5 9';
    $this->assertEquals(504, $p->p(explode("\r\n", $s)));
  }
}