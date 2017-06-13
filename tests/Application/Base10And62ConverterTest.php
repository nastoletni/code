<?php

namespace Nastoletni\Code\Application;

use PHPUnit\Framework\TestCase;

class Base10And62ConverterTest extends TestCase
{
    /**
     * @dataProvider baseConverterProvider
     */
    public function testBase10ToBase62($base10, $base62)
    {
        $this->assertEquals($base62, Base10And62Converter::base10To62($base10));
    }

    /**
     * @dataProvider baseConverterProvider
     */
    public function testBase62ToBase10($base10, $base62)
    {
        $this->assertEquals($base10, Base10And62Converter::base62To10($base62));
    }

    public function baseConverterProvider()
    {
        return [
            [1, '1'],
            [2, '2'],
            [10, 'a'],
            [36, 'A'],
            [62, '10'],
            [72, '1a'],
            [99, '1B'],
        ];
    }
}
