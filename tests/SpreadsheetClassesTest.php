<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use Box\Spout\Reader\XLSX\Reader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadsheetClassesTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class SpreadsheetClassesTest extends TestCase
{
    public static function testPreferred(): void
    {
        SpreadsheetClasses::setPreferred(SpreadsheetClasses::SPREADSHEET);

        self::assertEquals(SpreadsheetClasses::SPREADSHEET, SpreadsheetClasses::$preferred);

        SpreadsheetClasses::setPreferred();

        self::assertNull(SpreadsheetClasses::$preferred);
    }

    public static function testIdentifyNull(): void
    {
        self::assertNull(SpreadsheetClasses::identify(''));
        self::assertNull(SpreadsheetClasses::identify(null));
        self::assertNull(SpreadsheetClasses::identify([]));
    }

    public static function testIdentify(): void
    {
        self::assertGreaterThan(1, \count(SpreadsheetClasses::$namespaces));
    }

    public static function testNamespacesExist(): void
    {
        foreach (SpreadsheetClasses::$namespaces as $namespace) {
            self::assertTrue(SpreadsheetClasses::isAvailable($namespace));
        }
    }

    public static function testNamespacesBlank(): void
    {
        self::assertFalse(SpreadsheetClasses::isAvailable(''));
    }

    public static function testIdentifyObjSpout(): void
    {
        if (!SpreadsheetClasses::isAvailable(SpreadsheetClasses::SPOUT)) {
            self::markTestSkipped('Spout not found');
        }

        $reader = new Reader();

        self::assertEquals(SpreadsheetClasses::SPOUT, SpreadsheetClasses::identify($reader));
    }

    public static function testIdentifyObjPhpSpreadsheet(): void
    {
        if (!SpreadsheetClasses::isAvailable(SpreadsheetClasses::SPREADSHEET)) {
            self::markTestSkipped('PhpSpreadsheet not found');
        }

        $book = new Spreadsheet();

        self::assertEquals(SpreadsheetClasses::SPREADSHEET, SpreadsheetClasses::identify($book));
    }
}
