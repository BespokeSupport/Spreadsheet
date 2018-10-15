<?php

namespace BespokeSupport\Spreadsheet\Tests;

use ArrayIterator;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\SpreadsheetHeader;
use BespokeSupport\Spreadsheet\TableRows;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadsheetHeaderTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class SpreadsheetHeaderTest extends TestCase
{
    public function testHeaderStatics(): void
    {
        static::assertEquals(1, SpreadsheetHeader::getHeaderOn());
        static::assertEquals(2, SpreadsheetHeader::getDataStarts());
    }

    public function testHeaderRow(): void
    {
        $row0 = SpreadsheetHeader::isData(0);
        $row1 = SpreadsheetHeader::isData(1);
        $row2 = SpreadsheetHeader::isData(2);

        static::assertFalse($row0);
        static::assertFalse($row1);
        static::assertTrue($row2);

        $iterator = new ArrayIterator([[1]]);
        $rows = new TableRows($iterator, SpreadsheetClasses::SPOUT);

        SpreadsheetHeader::header($rows->current());

        //reset after use
        SpreadsheetHeader::header();
    }

    public function testHeaderRowExpand(): void
    {
        SpreadsheetHeader::setHeaderOn(2);

        static::assertEquals(2, SpreadsheetHeader::getHeaderOn());
        static::assertEquals(3, SpreadsheetHeader::getDataStarts());

        //reset after use
        SpreadsheetHeader::header();
    }

    public function testHeaderDataBlank(): void
    {
        SpreadsheetHeader::setDataStarts(2);

        static::assertFalse(SpreadsheetHeader::isData(0));
        static::assertFalse(SpreadsheetHeader::isData(1));
        static::assertTrue(SpreadsheetHeader::isData(2));
        static::assertTrue(SpreadsheetHeader::isData(3));
    }

    public function testHeaderSet(): void
    {
        $header = ['id' => 1];
        SpreadsheetHeader::set($header);
        static::assertEquals($header, SpreadsheetHeader::$header);
        SpreadsheetHeader::set([]);
    }

    public function testIterator(): void
    {
        SpreadsheetHeader::header();
        self::assertTrue(true);
    }

    public function testNoHeader(): void
    {
        SpreadsheetHeader::noHeader();

        self::assertCount(0, SpreadsheetHeader::$header);
        self::assertEquals(1, SpreadsheetHeader::getDataStarts());
        self::assertNull(SpreadsheetHeader::getHeaderOn());
    }
}
