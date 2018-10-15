<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

/**
 * Interface ConverterTestInterface
 * @package BespokeSupport\Spreadsheet\Tests\Converter
 */
interface ConverterTestInterface
{
    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testFailMime(): void;
    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testFailType(): void;
    public static function testRead(): void;
    public static function testBookToSheets(): void;
    public static function testBookToSheet(): void;
    public static function testSheetsToSheet(): void;
    public static function testSheetToRows(): void;
    public static function testRowsToRow(): void;
    public static function testRowToData(): void;
    public static function testRowToSheet(): void;
    public static function testRowsCount(): void;
    public static function testRowsNext(): void;
    public static function testSheetsCount(): void;
    public static function testSheetByName(): void;
}
