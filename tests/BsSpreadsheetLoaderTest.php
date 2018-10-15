<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\BsSpreadsheetLoader;
use BespokeSupport\Spreadsheet\ConvertTableEntities;
use BespokeSupport\Spreadsheet\Exception\TableLoaderException;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use PHPUnit\Framework\TestCase;

/**
 * Class BsSpreadsheetLoaderTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class BsSpreadsheetLoaderTest extends TestCase
{
    public function testReadSpout(): void
    {
        BsSpreadsheetLoader::read(__DIR__ . '/files/example.csv', SpreadsheetClasses::SPOUT);

        self::assertTrue(true);
    }

    public function testReadGuessedSpout(): void
    {
        $packages = SpreadsheetClasses::$packages;

        unset(SpreadsheetClasses::$packages[SpreadsheetClasses::SPOUT]);

        BsSpreadsheetLoader::read(__DIR__ . '/files/example.csv', SpreadsheetClasses::EXAMPLE);

        SpreadsheetClasses::setPackages($packages);

        self::assertTrue(true);
    }

    public function testReadGuessedPhpSpreadsheet(): void
    {
        $packages = SpreadsheetClasses::$packages;

        unset(SpreadsheetClasses::$packages[SpreadsheetClasses::SPREADSHEET]);

        BsSpreadsheetLoader::read(__DIR__ . '/files/example.csv', SpreadsheetClasses::EXAMPLE);

        SpreadsheetClasses::setPackages($packages);

        self::assertTrue(true);
    }

    public function testReadFail(): void
    {
        $packages = SpreadsheetClasses::$packages;

        SpreadsheetClasses::setPackages([]);

        try {
            BsSpreadsheetLoader::read(__DIR__ . '/files/example.csv', SpreadsheetClasses::EXAMPLE);
            self::assertTrue(false);
        } catch (TableLoaderException $e) {
            self::assertTrue(true);
        }

        SpreadsheetClasses::setPackages($packages);
    }
}
