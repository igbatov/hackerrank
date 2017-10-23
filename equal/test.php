<?php

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
    //$str = '512 125 928 381 890 90 512 789 469 473 908 990 195 763 102 643 458 366 684 857 126 534 974 875 459 892 686 373 127 297 576 991 774 856 372 664 946 237 806 767 62 714 758 258 477 860 253 287 579 289 496';
    $str = '2 2 3 7';
    /**
     * 1 6, 2 5, 1 7, 3 5, 1 10, 6 1
     */
    $arr = explode(' ', $str);
    $arr = array_map(function($e){
      return (int)$e;
    }, $arr);
    $r = $p->calc([$arr]);
    var_dump($r);
    //$this->assertEquals([2], $r);
  }
}

