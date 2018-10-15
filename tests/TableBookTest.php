<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use Box\Spout\Reader\CSV\Reader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

/**
 * Class TableBookTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class TableBookTest extends TestCase
{

    public function testPackagePhpSpreadsheet(): void
    {
        $native = new Spreadsheet();

        $book = new TableBook($native, SpreadsheetClasses::SPREADSHEET);

        self::assertNotNull($book->packagePhpSpreadsheet());
    }

    public function testPackageSpout(): void
    {
        $native = new Reader();

        $book = new TableBook($native, SpreadsheetClasses::SPOUT);

        self::assertNotNull($book->packageSpout());
    }
}
