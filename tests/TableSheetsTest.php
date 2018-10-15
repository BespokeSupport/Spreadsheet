<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\Converter\ConverterExample;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableSheets;
use PHPUnit\Framework\TestCase;

/**
 * Class TableSheetsTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class TableSheetsTest extends TestCase
{
    /**
     * @return TableBook
     */
    private static function getBook(): TableBook
    {
        return ConverterExample::read('');
    }

    /**
     * @return TableSheets
     */
    private static function getSheets(): TableSheets
    {
        $book = self::getBook();

        return ConverterExample::bookToSheets($book);
    }

    public function testKey(): void
    {
        $sheets = self::getSheets();

        self::assertEquals(0, $sheets->key());
    }

    public function testNext(): void
    {
        $sheets = self::getSheets();

        $sheets->next();

        self::assertTrue(true);
    }

    public function testCurrent(): void
    {
        $sheets = self::getSheets();

        $sheets->current();

        self::assertTrue(true);
    }

    public function testRewind(): void
    {
        $sheets = self::getSheets();

        $sheets->rewind();

        self::assertTrue(true);
    }

    public function testValid(): void
    {
        $sheets = self::getSheets();

        self::assertTrue($sheets->valid());
    }
}
