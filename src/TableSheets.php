<?php

namespace BespokeSupport\Spreadsheet;

use ArrayIterator;
use BespokeSupport\Spreadsheet\Exception\TableReaderException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Reader\CSV\SheetIterator as CSVIterator;
use Box\Spout\Reader\IteratorInterface;
use Box\Spout\Reader\ODS\SheetIterator as ODSIterator;
use Box\Spout\Reader\XLSX\SheetIterator as XLSIterator;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class TableSheets
 * @package BespokeSupport\Spreadsheet
 */
class TableSheets extends ArrayIterator
{
    /**
     * @var CSVIterator|ODSIterator|XLSIterator|Spreadsheet
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
            parent::__construct($this->native->getAllSheets());
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        if ($this->source === SpreadsheetClasses::SPOUT) {
            $this->native->end();

            $key = $this->native->key();

            try {
                $this->native->rewind();
                // @codeCoverageIgnoreStart
            } catch (IOException $e) {
                throw new TableReaderException('', 0, $e);
            }
            // @codeCoverageIgnoreEnd

            return $key;
        }

        if ($this->source === SpreadsheetClasses::SPREADSHEET) {
            return \count($this->native->getAllSheets());
        }

        return 0;
    }

    /**
     *
     */
    public function current()
    {
        if (\is_array($this->native)) {
            return new TableSheet(current($this->native), $this->source);
        }

        return new TableSheet($this->native->current(), $this->source);
    }

    /**
     * @return int|mixed
     */
    public function key()
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
        if (\is_array($this->native)) {
            next($this->native);
            return;
        }

        $this->native->next();
    }

    /**
     * @return Spreadsheet
     */
    public function packagePhpSpreadsheet(): Spreadsheet
    {
        return $this->native;
    }

    /**
     * @return CSVIterator|ODSIterator|XLSIterator
     */
    public function packageSpout(): IteratorInterface
    {
        return $this->native;
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
     * @return TableSheet
     */
    public function sheet(): TableSheet
    {
        return ConvertTableEntities::sheetsToSheet($this);
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
