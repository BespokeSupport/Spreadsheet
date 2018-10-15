<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

use BespokeSupport\Spreadsheet\Converter\ConverterExample;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableSheet;
use PHPUnit\Framework\TestCase;

/**
 * Class ConverterExampleTest
 * @package BespokeSupport\Spreadsheet\Tests\Converter
 */
class ConverterExampleTest extends TestCase implements ConverterTestInterface
{
    public const CONVERTER = 'Example';

    /**
     * @return TableBook
     */
    private static function getBook(): TableBook
    {
        return ConverterExample::read('');
    }

    /**
     * @return TableSheet
     */
    private static function getSheet(): TableSheet
    {
        $book = self::getBook();

        return ConverterExample::bookToSheet($book);
    }

    public static function testFailMime(): void
    {
        self::markTestSkipped('No Example testFailMime');
    }

    public static function testFailType(): void
    {
        self::markTestSkipped('No Example testFailType');
    }

    public static function testRead(): void
    {
        $ent = self::getBook();

        self::assertNotNull($ent);
    }

    public static function testBookToSheets(): void
    {
        $book = self::getBook();

        $ent = $book->sheets();

        self::assertNotNull($ent);
    }

    public static function testBookToSheet(): void
    {
        $ent = self::getSheet();

        self::assertNotNull($ent);
    }

    public static function testSheetToBook(): void
    {
        $ent = self::getSheet();

        $ent = ConverterExample::sheetToBook($ent);

        self::assertNotNull($ent);
    }

    /**
     * @expectedException \Error
     */
    public static function testCell(): void
    {
        $ent = self::getSheet();

        ConverterExample::cell($ent, 'A1');
    }

    public static function testSheetsToSheet(): void
    {
        $book = self::getBook();

        $ent = $book->sheets();

        $ent = $ent->sheet();

        self::assertNotNull($ent);
    }

    public static function testSheetToRows(): void
    {
        $sheet = self::getSheet();

        $ent = $sheet->rows();

        self::assertNotNull($ent);
    }

    public static function testRowsToRow(): void
    {
        $sheet = self::getSheet();

        $ent = $sheet->rows();

        $ent = ConverterExample::rowsToRow($ent);

        self::assertNotNull($ent);
    }

    public static function testRowToData(): void
    {
        $sheet = self::getSheet();

        $ent = $sheet->rows();

        $ent = $ent->current();

        $ent = $ent->native;

        self::assertNotNull($ent);
    }

    public static function testRowToSheet(): void
    {
        $sheet = self::getSheet();

        $ent = $sheet->rows()->current();

        $ent = $ent->sheet();

        self::assertNotNull($ent);
    }

    public static function testCountRows(): void
    {
        $sheet = self::getSheet();

        $ent = $sheet->rows();

        self::assertCount(2, $ent);
    }

    public static function testRewind(): void
    {
        $sheet = self::getSheet();

        $rows = $sheet->rows();

        self::assertEquals(0, $rows->key());

        $rows->next();

        self::assertEquals(1, $rows->key());

        $rows->rewind();

        self::assertEquals(0, $rows->key());
    }

    public static function testRowsCount(): void
    {
        $sheet = self::getSheet();

        $rows = $sheet->rows();

        self::assertEquals(2, $rows->count());
    }

    public static function testRowsNext(): void
    {
        $sheet = self::getSheet();

        $rows = $sheet->rows();

        ConverterExample::rowsNext($rows);

        self::assertTrue(true);
    }

    public static function testSheetsCount(): void
    {
        $sheets = self::getBook()->sheets();

        self::assertEquals(0, $sheets->count());
    }

    /**
     * @expectedException \Error
     */
    public static function testSheetByName(): void
    {
        $book = self::getBook();

        ConverterExample::sheetByName($book, 'Sheet1');
    }
}
