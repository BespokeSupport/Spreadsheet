<?php

namespace BespokeSupport\Spreadsheet;

use Box\Spout\Reader\AbstractReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class SpreadsheetClasses
 * @package BespokeSupport\Spreadsheet
 */
class SpreadsheetClasses
{
    public const EXAMPLE = 'EXAMPLE';
    public const SPOUT = 'SPOUT';
    public const SPREADSHEET = 'SPREADSHEET';
    public static $namespaces = [
        'Box' => self::SPOUT,
        'PhpOffice' => self::SPREADSHEET,
    ];
    public static $packages = [
        self::EXAMPLE => 'Example',
        self::SPOUT => 'Spout',
        self::SPREADSHEET => 'PhpSpreadsheet',
    ];
    public static $preferred;

    /**
     * @param $obj
     * @return null|string
     */
    public static function identify($obj): ?string
    {
        if ($obj === null) {
            return null;
        }

        if (\is_array($obj)) {
            return null;
        }

        if (\is_string($obj)) {
            return null;
        }

        $className = \get_class($obj);

        $element = strstr($className, '\\', true);

        return self::$namespaces[$element] ?? null;
    }

    /**
     * @param $package
     * @return bool
     */
    public static function isAvailable(string $package): bool
    {
        switch ($package) {
            case self::SPOUT:
                return class_exists(AbstractReader::class);
            case self::SPREADSHEET:
                return class_exists(Spreadsheet::class);
            default:
                return false;
        }
    }

    /**
     * @param array $packages
     */
    public static function setPackages(array $packages): void
    {
        self::$packages = $packages;
    }

    /**
     * @param string $preferred
     */
    public static function setPreferred(string $preferred = null): void
    {
        self::$preferred = $preferred;
    }
}
