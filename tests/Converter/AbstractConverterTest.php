<?php

namespace BespokeSupport\Spreadsheet\Tests\Converter;

use BespokeSupport\Spreadsheet\Converter\AbstractConverter;
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
}
