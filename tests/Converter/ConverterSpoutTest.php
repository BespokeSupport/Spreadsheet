<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

use BespokeSupport\Spreadsheet\Converter\ConverterSpout;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use PHPUnit\Framework\TestCase;

/**
 * Class SpoutConverterTest
 * @package BespokeSupport\Spreadsheet\Tests\Converter
 */
class ConverterSpoutTest extends TestCase implements ConverterTestInterface
{
    public const CONVERTER = 'SpoutConverter';

    /**
     * @return TableBook
     */
    protected static function setupBook(): TableBook
    {
        $file = __DIR__ . '/../files/example.xlsx';
        return ConverterSpout::read($file);
    }

    /**
     * @return TableSheets
     */
    protected static function setupSheets(): TableSheets
    {
        $book = self::setupBook();
        return $book->sheets();
    }

    /**
     * @return TableSheet
     */
    protected static function setupSheet(): TableSheet
    {
        $book = self::setupBook();
        return $book->sheet();
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testFailMime(): void
    {
        $file = __DIR__ . '/../files/image.jpg';
        ConverterSpout::read($file);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown Mime"
     */
    public static function testFailMimeBlank(): void
    {
        $file = __DIR__ . '';
        ConverterSpout::read($file);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testFailType(): void
    {
        $file = __DIR__ . '/../files/example.ots';
        ConverterSpout::read($file);
    }

    public static function testRead(): void
    {
        $book = self::setupBook();

        self::assertNotNull($book);
    }

    public static function testBookToSheets(): void
    {
        $book = self::setupBook();

        $ret = ConverterSpout::bookToSheets($book);

        self::assertNotNull($ret);
    }

    public static function testBookToSheet(): void
    {
        $book = self::setupBook();

        $ret = ConverterSpout::bookToSheet($book);

        self::assertNotNull($ret);
    }

    public static function testSheetsToSheet(): void
    {
        $book = self::setupBook();

        $ret = ConverterSpout::sheetsToSheet($book->sheets());

        self::assertNotNull($ret);
    }


    public static function testSheetsToSheetCsv(): void
    {
        $file = __DIR__ . '/../files/example.csv';
        $book = ConverterSpout::read($file);

        $sheet = ConverterSpout::sheetsToSheet($book->sheets());

        self::assertNotNull($sheet);
    }

    public static function testSheetToRows(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterSpout::sheetToRows($sheet);

        self::assertNotNull($ret);
    }

    public static function testRowsToRow(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterSpout::rowsToRow($sheet->rows());

        self::assertNotNull($ret);
    }

    public static function testRowToData(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterSpout::rowToData($sheet->rows()->current());

        self::assertNotNull($ret);
    }

    /**
     * @expectedException \Error
     */
    public static function testCell(): void
    {
        $sheet = self::setupSheet();

        $sheet->cell('A1');
    }

    /**
     * @expectedException \Error
     */
    public static function testSheetToBook(): void
    {
        $sheet = self::setupSheet();

        $sheet->book();
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableReaderException
     */
    public static function testFailBookSheets(): void
    {
        $book = self::setupBook();

        $book->native->close();

        $book->sheets();
    }

    /**
     * @expectedException \Error
     */
    public static function testRowToSheet(): void
    {
        $sheet = self::setupSheet();

        $row = $sheet->rows()->current();

        $row->sheet();
    }

    public static function testRowsCount(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        $ret = ConverterSpout::countRows($rows);

        self::assertEquals(3, $ret);
    }

    public static function testSheetsCount(): void
    {
        $sheets = self::setupSheets();

        $ret = ConverterSpout::sheetsCount($sheets);

        self::assertEquals(1, $ret);
    }

    public static function testRowsRewind(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        self::assertEquals(0, $rows->key());

        $rows->next();

        self::assertEquals(0, $rows->key());

        $rows->rewind();

        self::assertEquals(1, $rows->key());
    }

    public static function testValid(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        self::assertTrue($rows->valid());
    }

    public static function testSheetsRewind(): void
    {
        $sheets = self::setupSheets();

        self::assertEquals(1, $sheets->key());

        $sheets->next();

        self::assertEquals(1, $sheets->key());

        $sheets->rewind();

        self::assertEquals(1, $sheets->key());
    }

    public static function testSheetsValid(): void
    {
        $sheets = self::setupSheets();

        $sheets->valid();

        self::assertTrue(true);
    }

    public static function testRowsNext(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        $rows->next();

        self::assertTrue(true);
    }

    public static function testPackage(): void
    {
        $sheets = self::setupSheets();

        self::assertNotNull($sheets->packageSpout());
    }

    public static function testSheetByName(): void
    {
        $book = self::setupBook();

        $sheet = ConverterSpout::sheetByName($book, 'Sheet1');

        self::assertNotNull($sheet);
    }

    public static function testSheetByNameFail(): void
    {
        $book = self::setupBook();

        $sheet = ConverterSpout::sheetByName($book, 'SheetUnknown');

        self::assertNull($sheet);
    }
}
