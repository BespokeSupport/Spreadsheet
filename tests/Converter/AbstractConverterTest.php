<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

use BespokeSupport\Spreadsheet\Converter\AbstractConverter;
use BespokeSupport\Spreadsheet\SpreadsheetClasses;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractConverterTest
 * @package BespokeSupport\Spreadsheet\Tests\Converter
 */
class AbstractConverterTest extends TestCase
{
    public static function testMimeToType(): void
    {
        $ret = AbstractConverter::mimeToType('', null);

        self::assertNull($ret);
    }

    public static function testMimeToTypeUnknown(): void
    {
        $ret = AbstractConverter::mimeToType(SpreadsheetClasses::EXAMPLE, 'text/plain');

        self::assertNull($ret);
    }
}
