<?php

namespace BespokeSupport\Spreadsheet;

/**
 * Class SpreadsheetHeader
 */
class SpreadsheetHeader
{
    /**
     * @var int
     */
    protected static $dataStarts = 2;
    /**
     * @var array
     */
    public static $header = [];
    /**
     * @var int|null
     */
    protected static $headerOn = 1;

    /**
     * @return int
     */
    public static function getDataStarts(): int
    {
        return self::$dataStarts;
    }

    /**
     * @return int|null
     */
    public static function getHeaderOn(): ?int
    {
        return self::$headerOn;
    }

    /**
     * @param TableRow|null $row
     * @return TableRow|null
     */
    public static function header(TableRow $row = null): ?TableRow
    {
        if (!$row) {
            self::$header = [];
            return null;
        }

        self::$header = ConvertTableEntities::rowToData($row);

        return $row;
    }

    /**
     * @param int $key
     * @return bool
     */
    public static function isData(int $key): bool
    {
        return ($key >= self::$dataStarts);
    }

    /**
     *
     */
    public static function noHeader(): void
    {
        self::setHeaderOn();
        self::setDataStarts();
        self::$header = [];
    }

    /**
     * @param $row
     */
    public static function set($row): void
    {
        self::$header = $row;
    }

    /**
     * @param int $dataStarts
     */
    public static function setDataStarts(int $dataStarts = 1): void
    {
        self::$dataStarts = $dataStarts;
    }

    /**
     * @param int|null $headerOn
     */
    public static function setHeaderOn(int $headerOn = null): void
    {
        self::$headerOn = $headerOn;

        if (self::$headerOn >= self::$dataStarts) {
            self::$dataStarts = self::$headerOn + 1;
        }
    }
}
