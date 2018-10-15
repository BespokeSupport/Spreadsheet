<?php

namespace BespokeSupport\Spreadsheet;

/**
 * Class SpreadsheetExtract
 * @package BespokeSupport\Spreadsheet
 */
class SpreadsheetExtract
{
    /**
     * Sum a group of columns
     *
     * @param array $row
     * @param array $filter
     * @return float
     */
    public static function sumValues(array $row, array $filter): float
    {
        $array = self::valuesExtract($row, $filter);

        $sum = array_sum($array);

        return (double)$sum;
    }

    /**
     * Filter a Row using a Query array
     *
     * @param array $row
     * @param array $filter
     * @return array
     */
    public static function valuesExtract(array $row, array $filter): array
    {
        return array_filter($row, function ($val, $key) use ($filter) {
            return \in_array($key, $filter, true);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
