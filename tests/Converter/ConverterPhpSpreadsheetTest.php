<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

use BespokeSupport\Spreadsheet\Converter\ConverterPhpSpreadsheet;
use BespokeSupport\Spreadsheet\ConvertTableEntities;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpSpreadsheetConverterTest
 * @package BespokeSupport\Spreadsheet\Tests\Converter
 */
class ConverterPhpSpreadsheetTest extends TestCase implements ConverterTestInterface
{
    public const CONVERTER = 'PhpSpreadsheet';

    public const PACKAGE = SpreadsheetClasses::SPREADSHEET;

    /**
     * @return TableBook
     */
    protected static function setupBook(): TableBook
    {
        return ConverterPhpSpreadsheet::read(self::setupPath());
    }

    /**
     * @return string
     */
    protected static function setupPath(): string
    {
        return __DIR__ . '/../files/example.xlsx';
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
     * @return TableSheets
     */
    protected static function setupSheets(): TableSheets
    {
        $book = self::setupBook();
        return $book->sheets();
    }

    public static function testBookToSheet(): void
    {
        $book = self::setupBook();

        $ret = ConverterPhpSpreadsheet::bookToSheet($book);

        self::assertNotNull($ret);
    }

    public static function testBookToSheets(): void
    {
        $book = self::setupBook();

        $ret = ConverterPhpSpreadsheet::bookToSheets($book);

        self::assertNotNull($ret);
    }

    public static function testCell(): void
    {
        $sheet = self::setupSheet();

        $cell = $sheet->cell('A1');

        self::assertNotNull($cell);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Cannot Load"
     */
    public static function testFailMime(): void
    {
        $file = __DIR__ . '/../files/image.jpg';
        ConverterPhpSpreadsheet::read($file);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Cannot Load"
     */
    public static function testFailType(): void
    {
        $file = __DIR__ . '/../files/example.ots';
        ConverterPhpSpreadsheet::read($file);
    }

    public static function testPackage(): void
    {
        $sheets = self::setupSheets();

        self::assertNotNull($sheets->packagePhpSpreadsheet());
    }

    public static function testRead(): void
    {
        $book = self::setupBook();

        self::assertNotNull($book);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Cannot Load"
     */
    public static function testReadBinary(): void
    {
        $file = __DIR__ . '/../files/fail-binary.bin';

        ConverterPhpSpreadsheet::read($file);

        self::assertTrue(false);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testPathToUseTypeBin(): void
    {
        $file = __DIR__ . '/../files/fail-binary.bin';

        ConverterPhpSpreadsheet::pathToUseType($file);

        self::assertTrue(false);
    }

    public static function testPathToUseTypeXls(): void
    {
        $file = __DIR__ . '/../files/example.xls';

        $type = ConverterPhpSpreadsheet::pathToUseType($file);

        self::assertEquals('Xls', $type);
    }

    public static function testReadFromLoader(): void
    {
        $path = self::setupPath();

        $reader = ConverterPhpSpreadsheet::pathToReader($path);

        self::assertNotNull($reader);

        $book = ConverterPhpSpreadsheet::readFromLoader($reader, $path);

        self::assertNotNull($book);
    }

    public static function testRowToData(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterPhpSpreadsheet::rowToData($sheet->rows()->current());

        self::assertNotNull($ret);
    }

    public static function testRowToSheet(): void
    {
        $sheet = self::setupSheet();

        $row = $sheet->rows()->current();

        ConverterPhpSpreadsheet::rowToSheet($row);

        self::assertTrue(true);
    }

    public static function testRowsCount(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        $ret = ConverterPhpSpreadsheet::countRows($rows);

        self::assertEquals(3, $ret);
    }

    public static function testRowsNext(): void
    {
        $sheet = self::setupSheet();

        $rows = $sheet->rows();

        $rows->next();

        self::assertTrue(true);
    }

    public static function testRowsToRow(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterPhpSpreadsheet::rowsToRow($sheet->rows());

        self::assertNotNull($ret);
    }

    public static function testSheetByName(): void
    {
        $book = self::setupBook();

        $sheet = ConverterPhpSpreadsheet::sheetByName($book, 'Sheet1');

        self::assertNotNull($sheet);
    }

    public static function testSheetByNameConverter(): void
    {
        $book = self::setupBook();

        $sheet = ConvertTableEntities::sheetByName($book, 'Sheet1');

        self::assertNotNull($sheet);
    }

    public static function testSheetByNameFail(): void
    {
        $book = self::setupBook();

        $sheet = ConverterPhpSpreadsheet::sheetByName($book, 'SheetUnknown');

        self::assertNull($sheet);
    }

    public static function testSheetToBook(): void
    {
        $sheet = self::setupSheet();

        $book = $sheet->book();

        self::assertNotNull($book);
    }

    public static function testSheetToRows(): void
    {
        $sheet = self::setupSheet();

        $ret = ConverterPhpSpreadsheet::sheetToRows($sheet);

        self::assertNotNull($ret);
    }

    public static function testSheetsCount(): void
    {
        $sheets = self::setupSheets();

        self::assertNotNull($sheets->packagePhpSpreadsheet());
    }

    public static function testSheetsToSheet(): void
    {
        $book = self::setupBook();

        $ret = ConverterPhpSpreadsheet::sheetsToSheet($book->sheets());

        self::assertNotNull($ret);
    }

    public static function testSheetsToSheetBlank(): void
    {
        $file = __DIR__ . '/../files/fail-sheets.xlsx';
        $book = ConverterPhpSpreadsheet::read($file);

        $sheet = ConverterPhpSpreadsheet::sheetsToSheet($book->sheets());

        self::assertNotNull($sheet);
    }

    public static function testSheetsToSheetCsv(): void
    {
        $file = __DIR__ . '/../files/example.csv';

        $book = ConverterPhpSpreadsheet::read($file);

        $sheet = ConverterPhpSpreadsheet::sheetsToSheet($book->sheets());

        self::assertNotNull($sheet);
    }

    public static function testSheetsToSheetOds(): void
    {
        $file = __DIR__ . '/../files/example.ods';

        $book = ConverterPhpSpreadsheet::read($file);

        $sheet = ConverterPhpSpreadsheet::sheetsToSheet($book->sheets());

        self::assertNotNull($sheet);
    }

    public static function testSheetsToSheetXls(): void
    {
        $file = __DIR__ . '/../files/example.xls';

        $book = ConverterPhpSpreadsheet::read($file);

        $sheet = ConverterPhpSpreadsheet::sheetsToSheet($book->sheets());

        self::assertNotNull($sheet);
    }
}
