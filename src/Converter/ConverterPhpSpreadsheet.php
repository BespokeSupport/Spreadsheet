<?php

namespace BespokeSupport\Spreadsheet\Converter;

use BespokeSupport\Mime\FileMimes;
use BespokeSupport\Spreadsheet\Exception\TableLoaderException;
use BespokeSupport\Spreadsheet\Exception\TableReaderException;
use BespokeSupport\Spreadsheet\PackageExtension\PhpSpreadsheetRowIterator;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\SpreadsheetMimes;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableRows;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\BaseReader;

/**
 * Class ConverterPhpSpreadsheet
 * @package BespokeSupport\Spreadsheet\Converter
 */
class ConverterPhpSpreadsheet extends AbstractConverter implements ConverterInterface
{
    protected static $mimeToTypeConvert = [
        'csv' => 'Csv',
        'ods' => 'Ods',
        'xlsx' => 'Xlsx',
    ];
    /**
     * @var string
     */
    protected static $package = SpreadsheetClasses::SPREADSHEET;

    /**
     * @param TableBook $ent
     * @return TableSheet
     */
    public static function bookToSheet(TableBook $ent): TableSheet
    {
        try {
            return new TableSheet($ent->native->getSheet(0), self::$package);
            // @codeCoverageIgnoreStart
        } catch (SpreadsheetException $e) {
            throw new TableReaderException($e->getMessage(), 0, $e);
        }
        // @codeCoverageIgnoreEnd
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
        try {
            $ret = $ent->native->getCell($cell);
            return $ret ? $ret->getCalculatedValue() : null;
            // @codeCoverageIgnoreStart
        } catch (SpreadsheetException $e) {
            throw new TableReaderException('', 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param TableRows $rows
     * @return int
     */
    public static function countRows(TableRows $rows): int
    {
        return $rows->native->getHighestRow();
    }

    /**
     * 'xls': // dealt with in read()
     *
     * @param string $package
     * @param string|null $mime
     * @return null|string
     */
    public static function mimeToType(string $package, $mime): ?string
    {
        $type = parent::mimeToType(SpreadsheetClasses::SPREADSHEET, $mime);

        return self::$mimeToTypeConvert[$type] ?? null;
    }

    /**
     * @param $path
     * @return BaseReader
     */
    public static function pathToReader($path): BaseReader
    {
        $useType = self::pathToUseType($path);

        try {
            /**
             * @var $reader BaseReader
             */
            $reader = IOFactory::createReader($useType);
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            return $reader;
            // @codeCoverageIgnoreStart
            // TODO craft xlsx
        } catch (SpreadsheetException $e) {
            throw new TableLoaderException("Cannot Load | $path | ", 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param $path
     * @return null|string
     */
    public static function pathToUseType($path): ?string
    {
        $path = (string)$path;

        $mime = SpreadsheetMimes::pathToMime($path);

        $mimeToType = self::mimeToType(SpreadsheetClasses::SPREADSHEET, $mime);

        if (!$mimeToType && $mime === 'application/octet-stream' &&
            strtolower(SpreadsheetMimes::pathToExtension($path)) === 'xls') {
            $mimeToType = 'Xls';
        }

        if (!$mimeToType) {
            throw new TableLoaderException("Unknown type | $mime | $path", 0);
        }

        return $mimeToType;
    }

    /**
     * @param string $path
     * @return TableBook
     */
    public static function read($path): TableBook
    {
        try {
            return new TableBook(IOFactory::load($path), SpreadsheetClasses::SPREADSHEET);
            // @codeCoverageIgnoreStart
        } catch (SpreadsheetException $e) {
            $mime = FileMimes::read($path);
            throw new TableLoaderException("Cannot Load | $mime | $path | ", 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param BaseReader $reader
     * @param string $path
     * @return TableBook
     */
    public static function readFromLoader(BaseReader $reader, string $path): ?TableBook
    {
        try {
            return new TableBook($reader->load($path), SpreadsheetClasses::SPREADSHEET);
            // @codeCoverageIgnoreStart
        } catch (SpreadsheetException $e) {
            $mime = FileMimes::read($path);
            throw new TableLoaderException("Cannot Load | $mime | $path | ", 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param TableRow $row
     * @return array
     */
    public static function rowToData(TableRow $row): array
    {
        $data = [];

        $maxCol = $row->sheet()->native->getHighestColumn($row->native->getRowIndex());

        $cells = $row->native->getCellIterator('A', $maxCol);
        foreach ($cells as $cell) {
            try {
                $data[] = $cell->getCalculatedValue();
                // @codeCoverageIgnoreStart
                // TODO craft xlsx
            } catch (SpreadsheetException $e) {
                // @codeCoverageIgnoreEnd
                $data[] = null;
            }
        }

        return $data;
    }

    /**
     * @param TableRow $row
     * @return TableSheet
     */
    public static function rowToSheet(TableRow $row): TableSheet
    {
        return new TableSheet($row->native->getWorksheet(), self::$package);
    }

    /**
     * @param TableRows $rows
     * @return TableRow
     */
    public static function rowsToRow(TableRows $rows): TableRow
    {
        return $rows->current();
    }

    /**
     * @param TableBook $ent
     * @param string $name
     * @return TableSheet|null
     */
    public static function sheetByName(TableBook $ent, string $name): ?TableSheet
    {
        $sheet = $ent->packagePhpSpreadsheet()->getSheetByName($name);

        if (!$sheet) {
            return null;
        }

        return new TableSheet($sheet, self::$package);
    }

    /**
     * @param TableSheet $ent
     * @return TableBook
     */
    public static function sheetToBook(TableSheet $ent): TableBook
    {
        return new TableBook($ent->native->getParent(), self::$package);
    }

    /**
     * @param TableSheet $ent
     * @return TableRows
     */
    public static function sheetToRows(TableSheet $ent): TableRows
    {
        $iterator = new PhpSpreadsheetRowIterator($ent->native, 1, null);

        return new TableRows($iterator, self::$package);
    }

    /**
     * @param TableSheets $ent
     * @return TableSheet
     */
    public static function sheetsToSheet(TableSheets $ent): TableSheet
    {
        try {
            return new TableSheet($ent->native->getActiveSheet(), self::$package);
            // @codeCoverageIgnoreStart
            // TODO craft xlsx
        } catch (SpreadsheetException $e) {
            throw new TableReaderException('', 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }
}
