<?php

namespace BespokeSupport\Spreadsheet\Converter;

use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableRows;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use Error;
use SplFileInfo;

/**
 * Class ConverterExample
 * @package BespokeSupport\Spreadsheet\Converter
 */
class ConverterExample extends AbstractConverter implements ConverterInterface
{
    /**
     * @var string
     */
    protected static $package = SpreadsheetClasses::EXAMPLE;
    /**
     * @var array
     */
    public static $rows = [
        ['id', 'text'],
        [2, 'example'],
    ];
    /**
     * @var array
     */
    public static $sheets = [
        [],
        [],
    ];

    /**
     * @param TableBook $ent
     * @return TableSheet
     */
    public static function bookToSheet(TableBook $ent): TableSheet
    {
        return new TableSheet(self::$rows, self::$package);
    }

    /**
     * @param TableBook $ent
     * @return TableSheets
     */
    public static function bookToSheets(TableBook $ent): TableSheets
    {
        return new TableSheets($ent->native, self::$package);
    }

    /**
     * @param TableSheet $ent
     * @param string $cell
     * @return mixed
     */
    public static function cell(TableSheet $ent, string $cell)
    {
        throw new Error('Cannot access cells using Test');
    }

    /**
     * @param TableRows $ent
     * @return int
     */
    public static function countRows(TableRows $ent): int
    {
        return \count($ent->native);
    }

    /**
     * @param SplFileInfo|string $path
     * @return TableBook
     */
    public static function read($path): TableBook
    {
        return new TableBook(self::$sheets, self::$package);
    }

    /**
     * @param TableRow $ent
     * @return array
     */
    public static function rowToData(TableRow $ent): array
    {
        return $ent->native;
    }

    /**
     * @param TableRow $ent
     * @return TableSheet
     */
    public static function rowToSheet(TableRow $ent): TableSheet
    {
        return new TableSheet(self::$rows, self::$package);
    }

    /**
     * @param TableRows $ent
     * @return TableRow
     */
    public static function rowsToRow(TableRows $ent): TableRow
    {
        return new TableRow(current($ent->native), self::$package);
    }

    /**
     * @param TableBook $ent
     * @param string $name
     * @return TableSheet|null
     */
    public static function sheetByName(TableBook $ent, string $name): ?TableSheet
    {
        throw new Error('Cannot sheet names using Test');
    }

    /**
     * @param TableSheet $ent
     * @return TableBook
     */
    public static function sheetToBook(TableSheet $ent): TableBook
    {
        return new TableBook($ent->native, self::$package);
    }

    /**
     * @param TableSheet $ent
     * @return TableRows
     */
    public static function sheetToRows(TableSheet $ent): TableRows
    {
        return new TableRows($ent->native, self::$package);
    }

    /**
     * @param TableSheets $ent
     * @return TableSheet
     */
    public static function sheetsToSheet(TableSheets $ent): TableSheet
    {
        return new TableSheet($ent->native, self::$package);
    }
}
