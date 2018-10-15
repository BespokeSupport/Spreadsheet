<?php

namespace BespokeSupport\Spreadsheet\Converter;

use BespokeSupport\Spreadsheet\Exception\TableLoaderException;
use BespokeSupport\Spreadsheet\Exception\TableReaderException;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use BespokeSupport\Spreadsheet\SpreadsheetMimes;
use BespokeSupport\Spreadsheet\TableBook;
use BespokeSupport\Spreadsheet\TableRow;
use BespokeSupport\Spreadsheet\TableRows;
use BespokeSupport\Spreadsheet\TableSheet;
use BespokeSupport\Spreadsheet\TableSheets;
use Box\Spout\Common\Exception\SpoutException;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Reader\ReaderFactory;
use Error;

/**
 * Class ConverterSpout
 * @package BespokeSupport\Spreadsheet\Converter
 */
class ConverterSpout extends AbstractConverter implements ConverterInterface
{
    /**
     * @var string
     */
    protected static $package = SpreadsheetClasses::SPOUT;

    /**
     * @param TableBook $ent
     * @return TableSheet
     */
    public static function bookToSheet(TableBook $ent): TableSheet
    {
        return self::sheetsToSheet($ent->sheets());
    }

    /**
     * @param TableBook $ent
     * @return TableSheets
     */
    public static function bookToSheets(TableBook $ent): TableSheets
    {
        try {
            return new TableSheets($ent->native->getSheetIterator(), SpreadsheetClasses::SPOUT);
        } catch (ReaderNotOpenedException $e) {
            throw new TableReaderException('', 0, $e);
        }
    }

    /**
     * @param TableSheet $ent
     * @param string $cell
     */
    public static function cell(TableSheet $ent, string $cell)
    {
        throw new Error('Cannot access cells using Spout');
    }

    /**
     * @param TableRows $ent
     * @return int
     */
    public static function countRows(TableRows $ent): int
    {
        $count = 0;

        foreach ($ent->native as $row) {
            $count++;
        }

        return $count;
    }

    /**
     * @param string $package
     * @param string|null $mime
     * @return null|string
     */
    public static function mimeToType(string $package, $mime): ?string
    {
        return parent::mimeToType(SpreadsheetClasses::SPOUT, $mime);
    }

    /**
     * @param string $path
     * @return TableBook
     */
    public static function read($path): TableBook
    {
        $path = (string)$path;

        $mime = SpreadsheetMimes::pathToMime($path);

        if (!$mime) {
            throw new TableLoaderException("Unknown Mime| $path | ");
        }

        $mimeToType = self::mimeToType(SpreadsheetClasses::SPOUT, $mime);

        if (!$mimeToType) {
            throw new TableLoaderException("Unknown type | $mime | $path", 0);
        }

        try {
            $reader = ReaderFactory::create($mimeToType);
            $reader->open($path);
            return new TableBook($reader, SpreadsheetClasses::SPOUT);
            // @codeCoverageIgnoreStart
        } catch (SpoutException $e) {
            throw new TableLoaderException("Cannot Load | $path | ", 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param TableRow $ent
     * @return array
     */
    public static function rowToData(TableRow $ent): array
    {
        return (array)$ent->native;
    }

    /**
     * @param TableRow $ent
     * @return TableSheet
     */
    public static function rowToSheet(TableRow $ent): TableSheet
    {
        throw new Error('Cannot convert Row to Sheet using Spout');
    }

    /**
     * @param TableRows $ent
     * @return TableRow
     */
    public static function rowsToRow(TableRows $ent): TableRow
    {
        $native = $ent->native;

        try {
            $native->rewind();
            //@codeCoverageIgnoreStart
        } catch (SpoutException $e) {
            throw new TableReaderException('', 0, $e);
        }
        //@codeCoverageIgnoreEnd

        $row = $native->current();

        if ($row) {
            return new TableRow($row, SpreadsheetClasses::SPOUT);
        }

        // TODO craft files that cause this error
        //@codeCoverageIgnoreStart
        throw new TableReaderException('');
        //@codeCoverageIgnoreEnd
    }

    /**
     * @param TableBook $ent
     * @param string $name
     * @return TableSheet|null
     */
    public static function sheetByName(TableBook $ent, string $name): ?TableSheet
    {
        $sheets = $ent->sheets();

        foreach ($sheets as $sheet) {
            if ($sheet->native->getName() === $name) {
                return $sheet;
            }
        }

        return null;
    }

    /**
     * @param TableSheet $ent
     * @return TableBook
     */
    public static function sheetToBook(TableSheet $ent): TableBook
    {
        throw new Error('Cannot convert Sheet to Book using Spout');
    }

    /**
     * @param TableSheet $ent
     * @return TableRows
     */
    public static function sheetToRows(TableSheet $ent): TableRows
    {
        return new TableRows($ent->native->getRowIterator(), SpreadsheetClasses::SPOUT);
    }

    /**
     * @param TableSheets $ent
     * @return int
     */
    public static function sheetsCount(TableSheets $ent): int
    {
        $count = 0;

        foreach ($ent->packageSpout() as $sheet) {
            $count++;
        }

        return $count;
    }

    /**
     * @param TableSheets $ent
     * @return TableSheet
     */
    public static function sheetsToSheet(TableSheets $ent): TableSheet
    {
        $native = $ent->packageSpout();

        try {
            $native->rewind();
            // @codeCoverageIgnoreStart
        } catch (SpoutException $e) {
            throw new TableReaderException('', 0, $e);
        }
        // @codeCoverageIgnoreEnd

        $ent = $native->current();

        if ($ent) {
            return new TableSheet($ent, SpreadsheetClasses::SPOUT);
        }

        // TODO craft files that cause this error
        // @codeCoverageIgnoreStart
        throw new TableReaderException('');
        // @codeCoverageIgnoreEnd
    }
}
