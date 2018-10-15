<?php

namespace BespokeSupport\Spreadsheet\PackageExtension;

use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class PhpSpreadsheetRowIterator
 * @package BespokeSupport\Spreadsheet\PackageExtension
 */
final class PhpSpreadsheetRowIterator extends RowIterator
{
    /**
     * @var Worksheet
     */
    public $sheet;

    /**
     * PhpSpreadsheetRowIterator constructor.
     * @param Worksheet $subject
     * @param int $startRow
     * @param int|null $endRow
     */
    public function __construct(Worksheet $subject, int $startRow = 1, ?int $endRow = null)
    {
        parent::__construct($subject, $startRow, $endRow);

        $this->sheet = $subject;
    }

    /**
     * @return int
     */
    public function getHighestRow(): int
    {
        return $this->sheet->getHighestRow();
    }
}
