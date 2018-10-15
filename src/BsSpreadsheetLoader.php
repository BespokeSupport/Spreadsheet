<?php

namespace BespokeSupport\Spreadsheet;

use BespokeSupport\Spreadsheet\Converter\ConverterPhpSpreadsheet;
use BespokeSupport\Spreadsheet\Converter\ConverterSpout;
use BespokeSupport\Spreadsheet\Exception\TableLoaderException;
use Box\Spout\Reader\AbstractReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SplFileInfo;

/**
 * Class BsSpreadsheetLoader
 * @package BespokeSupport\Spreadsheet
 */
class BsSpreadsheetLoader
{
    /**
     * @param SplFileInfo|string $path
     * @param string|null $package
     * @return TableBook
     */
    public static function read($path, string $package = null): TableBook
    {
        if (!($path instanceof SplFileInfo)) {
            $path = new SplFileInfo($path);
        }

        if (!($path instanceof SplFileInfo) || !$path->isFile()) {
            throw new TableLoaderException("No file available | $package | $path");
        }

        if ($package === SpreadsheetClasses::SPREADSHEET) {
            return ConverterPhpSpreadsheet::read($path);
        }

        if ($package === SpreadsheetClasses::SPOUT) {
            return ConverterSpout::read($path);
        }

        if (array_key_exists(SpreadsheetClasses::SPOUT, SpreadsheetClasses::$packages) &&
            class_exists(AbstractReader::class)) {
            return ConverterSpout::read($path);
        }

        if (array_key_exists(SpreadsheetClasses::SPREADSHEET, SpreadsheetClasses::$packages) &&
            class_exists(Spreadsheet::class)) {
            return ConverterPhpSpreadsheet::read($path);
        }

        throw new TableLoaderException('No Loaders available');
    }
}
