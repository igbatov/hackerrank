<?php
include ('lib.php');
use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class ProcessTest extends TestCase
{
  public function dataProvider()
  {
    return [
        [
            '6 6 2 5
1 3
3 4
2 4
1 2
2 3
5 6',
          12
        ],
      [
          '3 3 2 1
1 2
3 1
2 3',
        4
      ]
    ];
  }
  /**
   * @dataProvider dataProvider
   */
  public function testProcess($test, $result)
  {
    $p = new Process();
    $p->setDebug(true);

    $lines = explode("\n", $test);
    $lines = array_map(function($e){
      return trim($e);
    }, $lines);
    list($n, $m, $clib, $croad) = explode(' ', $lines[0]);
    $cities = [];
    for ($i=1; $i<=$m; $i++) {
      list($city_1, $city_2) = explode(' ', $lines[$i]);
      $cities[$city_1][] = $city_2;
      $cities[$city_2][] = $city_1;
    }
    $this->assertEquals($result, $p->p($cities, $clib, $croad));
  }
}