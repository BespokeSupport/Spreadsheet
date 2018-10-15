<?php

namespace BespokeSupport\Spreadsheet\Tests\Entities;

use BespokeSupport\Spreadsheet\TableBook;
use PHPUnit\Framework\TestCase;

/**
 * Class EntitiesErrorsTest
 * @package BespokeSupport\Spreadsheet\Tests\Entities
 */
class EntitiesErrorsTest extends TestCase
{
    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testPlain(): void
    {
        $file = __DIR__ . '/../files/plain.txt';
        TableBook::read($file);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^Unknown type"
     */
    public static function testImage(): void
    {
        $file = __DIR__ . '/../files/image.jpg';
        TableBook::read($file);
    }

    /**
     * @expectedException \BespokeSupport\Spreadsheet\Exception\TableLoaderException
     * @expectedExceptionMessageRegExp "^No file"
     */
    public static function testBlank(): void
    {
        TableBook::read('    ');
    }
}
