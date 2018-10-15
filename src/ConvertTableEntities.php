<?php

namespace BespokeSupport\Spreadsheet;

use BespokeSupport\Spreadsheet\Converter\ConverterInterface;
use BespokeSupport\Spreadsheet\Exception\TableReaderException;
use SplFileInfo;

/**
 * Class ConvertTableEntities
 * @package BespokeSupport\Spreadsheet
 */
class ConvertTableEntities implements ConverterInterface
{
    /**
     * @param TableBook $ent
     * @return TableSheet
     */
    public static function bookToSheet(TableBook $ent): TableSheet
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableBook $ent
     * @return TableSheets
     */
    public static function bookToSheets(TableBook $ent): TableSheets
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableSheet $ent
     * @param string $cell
     * @return mixed
     */
    public static function cell(TableSheet $ent, string $cell)
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableRows $ent
     * @return int
     */
    public static function countRows(TableRows $ent): int
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param string $package
     * @param string|null $mime
     * @return string
     */
    public static function mimeToType(string $package, $mime): ?string
    {
        return self::passToConverter($package, __FUNCTION__, \func_get_args());
    }

    /**
     * @param $source
     * @param $method
     * @param array $args
     * @return mixed
     */
    private static function passToConverter($source, $method, array $args = [])
    {
        $class = SpreadsheetClasses::$packages[$source] ?? null;

        if (!$class) {
            throw new TableReaderException('No Loaders available');
        }

        $call = __NAMESPACE__ . '\Converter\Converter' . $class . '::' . $method;

        return forward_static_call_array($call, $args);
    }

    /**
     * @param SplFileInfo|string $path
     * @param string|null $package
     * @return TableBook
     */
    public static function read($path, string $package = null): TableBook
    {
        if ($package) {
            return self::passToConverter($package, __FUNCTION__, \func_get_args());
        }

        return BsSpreadsheetLoader::read($path, $package);
    }

    /**
     * @param TableRow $ent
     * @return array
     */
    public static function rowToData(TableRow $ent): array
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableRow $ent
     * @return TableSheet
     */
    public static function rowToSheet(TableRow $ent): TableSheet
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableRows $ent
     * @return TableRow
     */
    public static function rowsToRow(TableRows $ent): TableRow
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableBook $ent
     * @param string $name
     * @return TableSheet|null
     */
    public static function sheetByName(TableBook $ent, string $name): ?TableSheet
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableSheet $ent
     * @return TableBook
     */
    public static function sheetToBook(TableSheet $ent): TableBook
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableSheet $ent
     * @return TableRows
     */
    public static function sheetToRows(TableSheet $ent): TableRows
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }

    /**
     * @param TableSheets $ent
     * @return TableSheet
     */
    public static function sheetsToSheet(TableSheets $ent): TableSheet
    {
        return self::passToConverter($ent->source, __FUNCTION__, \func_get_args());
    }
}
