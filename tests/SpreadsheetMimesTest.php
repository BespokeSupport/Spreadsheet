<?php

namespace BespokeSupport\Spreadsheet\Tests;

use BespokeSupport\Spreadsheet\SpreadsheetMimes;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadsheetMimesTest
 * @package BespokeSupport\Spreadsheet\Tests
 */
class SpreadsheetMimesTest extends TestCase
{
    public function testPathToExtension(): void
    {
        $ext = SpreadsheetMimes::pathToExtension(__DIR__ . '/files/example.csv');

        self::assertEquals('csv', $ext);
    }
}
