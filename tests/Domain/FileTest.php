<?php

namespace Nastoletni\Code\Domain;

use Nastoletni\Code\Domain\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @dataProvider parameterProvider
     */
    public function testConstructorAndGetters($filename, $content)
    {
        $file = new File($filename, $content);

        $this->assertEquals($filename, $file->getFilename());
        $this->assertEquals($content, $file->getContent());
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testSettersAndGetters($filename, $content)
    {
        $file = new File('test.txt', 'test');

        $file->setFilename($filename);
        $file->setContent($content);

        $this->assertEquals($filename, $file->getFilename());
        $this->assertEquals($content, $file->getContent());
    }

    public function parameterProvider()
    {
        return [
            [null, 'test'],
            ['', 'test2'],
            ['test', 'test3'],
            ['test.txt', 'test4'],
            ['.test', 'test5']
        ];
    }
}
