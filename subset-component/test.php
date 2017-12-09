<?php
include ('binary_converter.php');
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
    $s = fopen('test_data/test2.txt', 'r');
    $this->assertEquals(5713, $p->run($s));
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