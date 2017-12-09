<?php
include ('lib.php');
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
    $s = fopen('test_data/test1.txt', 'r');
    $this->assertEquals(504, $p->run($s));
  }
}