<?php

namespace BespokeSupport\Spreadsheet;

use BespokeSupport\Mime\FileMimes;
use SplFileInfo;

/**
 * Class SpreadsheetMimes
 * @package BespokeSupport\Spreadsheet
 */
class SpreadsheetMimes
{
    /**
     * All the extensions that the package can handle
     *
     * @var array
     */
    public static $available = [
        SpreadsheetClasses::SPOUT => [
            'csv',
            'ods',
            'xlsx',
        ],
        SpreadsheetClasses::SPREADSHEET => [
            'csv',
            'ods',
            'xls',
            'xlsx',
            'xltx',
        ],
    ];
    /**
     * Spreadsheet mimes and extensions that any package can handle
     *
     * @var array
     */
    public static $mimes = [
        'text/plain' => 'csv',
        'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => 'xltx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.ms-excel.sheet.macroenabled.12' => 'xlsm',
        'application/vnd.ms-excel.sheet.binary.macroenabled.12' => 'xlsb',
        'application/octet-stream' => null,
    ];

    /**
     * @param $path
     * @return null|string
     */
    public static function pathToExtension($path): ?string
    {
        $spl = new SplFileInfo($path);

        return $spl->isFile() ? $spl->getExtension() : null;
    }

    /**
     * @param $path
     * @return string
     */
    public static function pathToMime($path): ?string
    {
        return FileMimes::read($path);
    }
}
