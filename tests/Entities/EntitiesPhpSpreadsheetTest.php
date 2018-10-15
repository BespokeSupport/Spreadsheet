<?php

namespace BespokeSupport\Spreadsheet\Tests\Entities;

use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableSheets;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * Class EntitiesPhpSpreadsheetTest
 * @package BespokeSupport\Spreadsheet\Tests\Entities
 */
class EntitiesPhpSpreadsheetTest extends TestCase
{
    public static $example = __DIR__ . '/../files/example.xlsx';

    public const PACKAGE = SpreadsheetClasses::SPREADSHEET;

    public static function testBookSpl(): void
    {
        $book = TableBook::read(new SplFileInfo(self::$example), self::PACKAGE);

        self::assertNotNull($book);
        self::assertEquals(SpreadsheetClasses::SPREADSHEET, $book->source);
    }

    public static function testBook(): void
    {
        $book = TableBook::read(self::$example, self::PACKAGE);

        self::assertCount(1, $book->sheets());

        self::assertNotNull($book->sheet());
    }

    public static function testSheet(): void
    {
        $book = TableBook::read(self::$example, self::PACKAGE);

        self::assertCount(1, $book->sheets());

        $sheet = $book->sheet();

        self::assertNotNull($sheet->book());
    }

    public static function testRows(): void
    {
        $book = TableBook::read(self::$example, self::PACKAGE);

        $sheet = $book->sheet();

        self::assertNotNull($sheet);

        $rows = $sheet->rows();

        self::assertCount(3, $rows);
    }

    public static function testRow(): void
    {
        $book = TableBook::read(self::$example, self::PACKAGE);

        $sheet = $book->sheet();

        self::assertNotNull($sheet);

        $rows = $sheet->rows();

        $row = $rows->current();

        self::assertInstanceOf(TableRow::class, $row);
    }

    /**
     * @expectedException \Error
     */
    public static function testSheetsCount(): void
    {
        $sheets = new TableSheets(null, self::PACKAGE);

        $sheets->count();

        self::assertTrue(false);
    }
}
