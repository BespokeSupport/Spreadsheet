<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\Converter\ConverterExample;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\SpreadsheetHeader;
use BespokeSupport\Spreadsheet\TableRows;
use PHPUnit\Framework\TestCase;

/**
 * Class TableRowTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class TableRowTest extends TestCase
{
    public function testConstructWithHeader(): void
    {
        $rows = new TableRows(ConverterExample::$rows, SpreadsheetClasses::EXAMPLE);

        SpreadsheetHeader::set(ConverterExample::$rows[0]);

        ConverterExample::rowsToRow($rows);

        SpreadsheetHeader::set([]);

        self::assertTrue(true);
    }

    public function testData1(): void
    {
        $rows = new TableRows(
            [
                [1,'one'],
            ],
            SpreadsheetClasses::EXAMPLE
        );

        $c = 0;
        foreach ($rows as $row) {
            $c++;
        }

        self::assertEquals(1, $c);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableReaderException
     */
    public function testNextFailNull(): void
    {
        $rows = new TableRows(
            null,
            SpreadsheetClasses::EXAMPLE
        );

        $rows->next();

        self::assertTrue(false);
    }

    public function testKey(): void
    {
        $rows = new TableRows(
            ConverterExample::$rows,
            SpreadsheetClasses::EXAMPLE
        );

        self::assertEquals(0, $rows->key());
    }
}
