<?php

namespace Nastoletni\Code\Application;

use Nastoletni\Code\Application\RandomIdGenerator;
use PHPUnit\Framework\TestCase;

class RandomIdGeneratorTest extends TestCase
{
    public function testBasicRandomness()
    {
        $history = [];

        for ($i = 0; $i < 1000; $i++) {
            $id = RandomIdGenerator::nextId()->getBase10Id();

            $this->assertNotContains($id, $history);
            $history[] = $id;
        }
    }
}
