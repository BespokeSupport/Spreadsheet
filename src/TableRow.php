<?php

namespace BespokeSupport\Spreadsheet;

use ArrayObject;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;

/**
 * Class TableRow
 * @package BespokeSupport\Spreadsheet
 */
class TableRow extends ArrayObject
{
    /**
     * @var Row|array
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
    public function __construct($native, $source)
    {
        $this->native = $native;
        $this->source = $source;

        $data = ConvertTableEntities::rowToData($this);

        if (SpreadsheetHeader::$header) {
            $row = array_combine(SpreadsheetHeader::$header, $data);

            parent::__construct($row);
        }
    }

    /**
     * @return TableSheet
     */
    public function sheet(): TableSheet
    {
        return ConvertTableEntities::rowToSheet($this);
    }
}
