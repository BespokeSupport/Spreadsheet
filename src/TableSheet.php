<?php

namespace BespokeSupport\Spreadsheet;

use Box\Spout\Reader\CSV\Sheet as CSVSheet;
use Box\Spout\Reader\ODS\Sheet as ODSSheet;
use Box\Spout\Reader\SheetInterface;
use Box\Spout\Reader\XLSX\Sheet as XLSSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class TableSheet
 * @package BespokeSupport\Spreadsheet
 */
class TableSheet
{
    /**
     * @var SheetInterface|CSVSheet|ODSSheet|XLSSheet|Worksheet
     */
    public $native;
    /**
     * @var string
     */
    public $source;

    /**
     * @param $native
     * @param $source
     */
    public function __construct($native, string $source)
    {
        $this->native = $native;
        $this->source = $source;
    }

    /**
     * @return TableBook
     */
    public function book(): TableBook
    {
        return ConvertTableEntities::sheetToBook($this);
    }

    /**
     * @param string $cell
     * @return mixed
     */
    public function cell($cell)
    {
        return ConvertTableEntities::cell($this, $cell);
    }

    /**
     * @return TableRows
     */
    public function rows(): TableRows
    {
        return ConvertTableEntities::sheetToRows($this);
    }
}
