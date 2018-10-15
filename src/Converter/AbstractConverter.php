<?php

namespace BespokeSupport\Spreadsheet\Converter;

use BespokeSupport\Spreadsheet\SpreadsheetMimes;

/**
 * Class AbstractConverter
 * @package BespokeSupport\Spreadsheet\Converter
 */
abstract class AbstractConverter
{
    /**
     * @var string
     */
    protected static $package;

    /**
     * @param string $package
     * @param string|null $mime
     * @return null|string
     */
    public static function mimeToType(string $package, $mime): ?string
    {
        $types = SpreadsheetMimes::$available[$package] ?? null;

        if (!$types) {
            return null;
        }

        if (!array_key_exists($mime, SpreadsheetMimes::$mimes)) {
            return null;
        }

        $ext = SpreadsheetMimes::$mimes[$mime];

        if (!\in_array($ext, $types, true)) {
            return null;
        }

        return $ext;
    }
}
