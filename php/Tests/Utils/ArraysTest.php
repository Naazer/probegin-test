<?php
/*
 * Created by Nazar Salo.
 * as the part of the test Task for Probegin
 * at 19.12.17 11:37
 */

namespace Tests\Utils;

use Utils\Arrays;
use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    /** @var Arrays */
    protected $arraysFixture;

    public function setUp()
    {
        $this->arraysFixture = new Arrays();
    }

    public function testSortByUnknownMethod()
    {
        $this->expectException(\TypeError::class);
        $this->arraysFixture->sortBy([$this->arraysFixture, 'nazarSort']);
    }

    /**
     * @dataProvider provider
     * @param array $array
     * @param string $sortingType
     */
    public function testQuickSortRight(array $array, string $sortingType)
    {
        $this->arraysFixture->setArray($array);
        $actual = $this->arraysFixture->sortBy([$this->arraysFixture, $sortingType]);
        $this->assertInternalType('array', $actual);
        sort($array);
        $this->assertEquals($array, $actual);
    }

    /**
     * @dataProvider provider
     * @param array $array
     * @param string $sortingType
     */
    public function testQuickSortWrong(array $array, string $sortingType)
    {
        $this->arraysFixture->setArray($array);
        $actual = $this->arraysFixture->sortBy([$this->arraysFixture, $sortingType]);
        $this->assertInternalType('array', $actual);
        $this->assertNotEquals($array, $actual);
    }

    public function provider()
    {
        return [
            [[34, 456, 34, 5456, 2, 100000, 342, 125], 'quickSort'],
            [[3, 5, 89, 1, 0, 123, 56, 66, 798, 100, 10000000, 3433], 'quickSort'],
            [[10, 9, 8, 7, 6, 5, 4, 3, 2, 1000, 22, 101, 205, 20010, 9999, 45, 12], 'bubbleSort'],
            [[1, 900000, 10, 400, 7000000, 6000000, 120, 100000000000, 23234234234], 'bubbleSort']
        ];
;    }
}
