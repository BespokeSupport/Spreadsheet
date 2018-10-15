<?php

namespace BespokeSupport\Spreadsheet;

use Box\Spout\Reader\ReaderInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class TableBook
 * @package BespokeSupport\Spreadsheet
 */
class TableBook
{
    /**
     * @var ReaderInterface|Spreadsheet
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
     * @param $path
     * @param null $package
     * @return TableBook|null
     */
    public static function read($path, $package = null): ?TableBook
    {
        return BsSpreadsheetLoader::read($path, $package);
    }

    /**
     * @return Spreadsheet
     */
    public function packagePhpSpreadsheet(): Spreadsheet
    {
        return $this->native;
    }

    /**
     * @return ReaderInterface
     */
    public function packageSpout(): ReaderInterface
    {
        return $this->native;
    }

    /**
     * @return TableSheet
     */
    public function sheet(): TableSheet
    {
        return $this->sheets()->sheet();
    }

    /**
     * @return TableSheets
     */
    public function sheets(): TableSheets
    {
        return ConvertTableEntities::bookToSheets($this);
    }
}
