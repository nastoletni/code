<?php

namespace Nastoletni\Code\Domain\Paste;

use Nastoletni\Code\Domain\Paste\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
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
