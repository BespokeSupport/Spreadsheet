<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\SpreadsheetExtract;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadsheetExtractTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class SpreadsheetExtractTest extends TestCase
{
    public function testValuesExtractEmpty(): void
    {
        $query = [];
        $row = [];

        $result = SpreadsheetExtract::valuesExtract($row, $query);

        self::assertCount(0, $result);
    }

    public function testValuesExtractTrue(): void
    {
        $query = ['id'];
        $row = [
            'id' => true,
            'ignore' => true,
        ];

        $result = SpreadsheetExtract::valuesExtract($row, $query);

        self::assertCount(1, $result);
        self::assertEquals(true, array_pop($result));
    }

    public function testValuesExtractInt(): void
    {
        $query = ['id'];
        $row = [
            'id' => 9,
            'ignore' => 9,
        ];

        $result = SpreadsheetExtract::valuesExtract($row, $query);

        self::assertCount(1, $result);
        self::assertEquals(9, array_pop($result));

    }

    public function testValuesExtractNull(): void
    {
        $query = ['id'];
        $row = [
            'id' => null,
            'ignore' => null,
        ];

        $result = SpreadsheetExtract::valuesExtract($row, $query);

        self::assertCount(1, $result);
    }

    public function testSumValuesEmpty(): void
    {
        $query = ['id'];
        $row = [
            'id' => 1,
            'ignore' => 1,
        ];

        $result = SpreadsheetExtract::sumValues($row, $query);

        self::assertEquals(1, $result);
    }
}
