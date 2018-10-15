<?php

namespace BespokeSupport\Spreadsheet;

use ArrayIterator;
use BespokeSupport\Spreadsheet\Exception\TableReaderException;
use BespokeSupport\Spreadsheet\PackageExtension\PhpSpreadsheetRowIterator;
use Box\Spout\Reader\CSV\RowIterator as CSVIterator;
use Box\Spout\Reader\ODS\RowIterator as ODSIterator;
use Box\Spout\Reader\XLSX\RowIterator as XLSIterator;
use Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;

/**
 * Class TableRows
 * @package BespokeSupport\Spreadsheet
 */
class TableRows extends ArrayIterator
{
    /**
     * @var CSVIterator|ODSIterator|XLSIterator|RowIterator|PhpSpreadsheetRowIterator|array
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

        if ($this->source === SpreadsheetClasses::SPOUT) {
            parent::__construct($this->native);
        }

        if ($this->source === SpreadsheetClasses::SPREADSHEET) {
            parent::__construct($this->native);
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return ConvertTableEntities::countRows($this);
    }

    /**
     * @return TableRow|mixed
     */
    public function current(): TableRow
    {
        $row = \is_array($this->native) ? current($this->native) : $this->native->current();

        return new TableRow($row, $this->source);
    }

    /**
     * @return int|mixed
     */
    public function key(): int
    {
        if (\is_array($this->native)) {
            return key($this->native);
        }

        return $this->native->key();
    }

    /**
     *
     */
    public function next(): void
    {
        if ($this->native === null) {
            throw new TableReaderException('Native null', 0);
        }

        if (\is_array($this->native)) {
            next($this->native);
            return;
        }

        try {
            ConvertTableEntities::rowsNext($this);
            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new TableReaderException('', 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     *
     */
    public function rewind(): void
    {
        if (\is_array($this->native)) {
            reset($this->native);
            return;
        }

        try {
            $this->native->rewind();
            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new TableReaderException('', 0, $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        if (\is_array($this->native)) {
            return key($this->native) !== null && key($this->native) < \count($this->native);
        }

        return $this->native->valid();
    }
}
