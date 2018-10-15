<?php

namespace BespokeSupport\Spreadsheet\Converter;

use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableRows;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use SplFileInfo;

/**
 * Interface ConverterInterface
 * @package BespokeSupport\Spreadsheet\Converter
 */
interface ConverterInterface
{
    /**
     * @param TableBook $ent
     * @return TableSheet
     */
    public static function bookToSheet(TableBook $ent): TableSheet;

    /**
     * @param TableBook $ent
     * @return TableSheets
     */
    public static function bookToSheets(TableBook $ent): TableSheets;

    /**
     * @param TableSheet $ent
     * @param string $cell
     * @return mixed
     */
    public static function cell(TableSheet $ent, string $cell);

    /**
     * @param TableRows $ent
     * @return int
     */
    public static function countRows(TableRows $ent): int;

    /**
     * @param string $package
     * @param string|null $mime
     * @return string
     */
    public static function mimeToType(string $package, $mime): ?string;

    /**
     * @param SplFileInfo|string $path
     * @return TableBook
     */
    public static function read($path): TableBook;

    /**
     * @param TableRow $ent
     * @return array
     */
    public static function rowToData(TableRow $ent): array;

    /**
     * @param TableRow $ent
     * @return TableSheet
     */
    public static function rowToSheet(TableRow $ent): TableSheet;

    /**
     * @param TableRows $ent
     * @return TableRow
     */
    public static function rowsToRow(TableRows $ent): TableRow;

    /**
     * @param TableBook $ent
     * @param string $name
     * @return TableSheet|null
     */
    public static function sheetByName(TableBook $ent, string $name): ?TableSheet;

    /**
     * @param TableSheet $ent
     * @return TableBook
     */
    public static function sheetToBook(TableSheet $ent): TableBook;

    /**
     * @param TableSheet $ent
     * @return TableRows
     */
    public static function sheetToRows(TableSheet $ent): TableRows;

    /**
     * @param TableSheets $ent
     * @return TableSheet
     */
    public static function sheetsToSheet(TableSheets $ent): TableSheet;
}
