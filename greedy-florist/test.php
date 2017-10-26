<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class ProcessTest extends TestCase
{
  public function testProcess()
  {
    $s = getMinimumCost(7, 2, [2, 5, 6, 5, 7, 9, 100]);
    $this->assertEquals(15, $s);
  }
}