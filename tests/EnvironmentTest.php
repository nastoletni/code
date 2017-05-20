<?php
declare(strict_types=1);

namespace Nastoletni\Code;

use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $env = new Environment();

        $this->assertFalse($env->getDebug());
    }

    public function testConstructor()
    {
        $env = new Environment(true);
        $this->assertTrue($env->getDebug());

        $env = new Environment(false);
        $this->assertFalse($env->getDebug());
    }

    /**
     * @dataProvider globalsProvider
     */
    public function testCreateFromGlobals($ip, $expected)
    {
        $_SERVER['REMOTE_ADDR'] = $ip;

        $env = Environment::createFromGlobals();
        $this->assertEquals($expected, $env->getDebug());
    }

    public function globalsProvider()
    {
        return [
            ['127.0.0.1', true],
            ['::1', true],
            ['172.217.20.174', false] // google.com
        ];
    }
}
