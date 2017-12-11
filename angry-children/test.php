<?php
include __DIR__.'/lib.php';
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
    $this->assertEquals(20, $p->run($s));
  }

//  public function testProcess()
//  {
//
//    $p = new Process();
//    $p->setDebug(true);
//    $s = fopen('test_data/test3.txt', 'r');
//    $this->assertEquals(93, $p->run($s));
//  }
}