<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\Converter\ConverterExample;
use BespokeSupport\Spreadsheet\ConvertTableEntities;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use PHPUnit\Framework\TestCase;

/**
 * Class ConvertTableEntitiesTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class ConvertTableEntitiesTest extends TestCase
{
    /**
     * @return TableBook
     */
    private static function getBook(): TableBook
    {
        return ConverterExample::read('');
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableReaderException
     */
    public function testNoLoader(): void
    {
        ConvertTableEntities::mimeToType('UNKNOWN', 'UNKNOWN');
    }

    public function testBookToSheet(): void
    {
        $ent = self::getBook();

        $res = ConvertTableEntities::bookToSheet($ent);

        self::assertNotNull($res);
    }

    public function testRowsToRow(): void
    {
        $ent = self::getBook()->sheet()->rows();

        $row = ConvertTableEntities::rowsToRow($ent);

        self::assertNotNull($row);
    }

    public function testRead(): void
    {
        $ent = ConvertTableEntities::read(__DIR__ . '/files/example.csv');

        self::assertNotNull($ent);
    }

    public function testReadSpout(): void
    {
        $ent = ConvertTableEntities::read(__DIR__ . '/files/example.csv', SpreadsheetClasses::SPOUT);

        self::assertNotNull($ent);
    }
}
