<?php

namespace Nastoletni\Code\Domain\Paste;

use Nastoletni\Code\Domain\Paste\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    /**
     * @dataProvider baseConverterProvider
     */
    public function testBase10ToBase62($base10, $base62)
    {
        $this->assertEquals($base62, Id::base10ToBase62($base10));
    }

    /**
     * @dataProvider baseConverterProvider
     */
    public function testBase62ToBase10($base10, $base62)
    {
        $this->assertEquals($base10, Id::base62ToBase10($base62));
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
            [99, '1B']
        ];
    }

    public function testBase10FabricMethodAndGetters()
    {
        $id = Id::createFromBase10(17);

        $this->assertEquals(17, $id->getBase10Id());
        $this->assertEquals('h', $id->getBase62Id());
    }

    public function testBase62FabricMethodAndGetters()
    {
        $id = Id::createFromBase62('CO2');

        $this->assertEquals(149174, $id->getBase10Id());
        $this->assertEquals('CO2', $id->getBase62Id());
    }
}
