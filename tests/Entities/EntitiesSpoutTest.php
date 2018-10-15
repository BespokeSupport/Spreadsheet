<?php

namespace BespokeSupport\Spreadsheet\Tests\Entities;

use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableSheets;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * Class EntitiesSpoutTest
 * @package BespokeSupport\Spreadsheet\Tests\Entities
 */
class EntitiesSpoutTest extends TestCase
{
    public static $example = __DIR__ . '/../files/example.xlsx';

    public static function setUpBeforeClass()
    {
        SpreadsheetClasses::setPreferred(SpreadsheetClasses::SPOUT);
    }

    public static function testBookSpl(): void
    {
        $book = TableBook::read(new SplFileInfo(self::$example));

        self::assertNotNull($book);
    }

    public static function testBook(): void
    {
        $book = TableBook::read(self::$example);

        self::assertCount(1, $book->sheets());

        self::assertNotNull($book->sheet());
    }

    /**
     * @expectedException \Error
     */
    public static function testSheet(): void
    {
        $book = TableBook::read(self::$example);

        $sheets = $book->sheets();

        self::assertCount(1, $sheets);

        $sheet = $book->sheet();

        self::assertNotNull($sheet->book());
    }

    public static function testRows(): void
    {
        $book = TableBook::read(self::$example);

        $sheet = $book->sheet();

        self::assertNotNull($sheet);

        self::assertCount(3, $sheet->rows());
    }

    public static function testRow(): void
    {
        $book = TableBook::read(self::$example);

        $sheet = $book->sheet();

        self::assertNotNull($sheet);

        $rows = $sheet->rows();

        self::assertCount(3, $rows);

        $row = $rows->current();

        self::assertInstanceOf(TableRow::class, $row);
    }

    /**
     * @expectedException \Error
     */
    public static function testSheetsCount(): void
    {
        $sheets = new TableSheets(null);

        $sheets->count();

        self::assertTrue(false);
    }
}
