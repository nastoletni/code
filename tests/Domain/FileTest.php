<?php

namespace Nastoletni\Code\Domain;

use Nastoletni\Code\Domain\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @dataProvider parameterProvider
     */
    public function testConstructorAndGetters($id, $filename, $content)
    {
        $file = new File($id, $filename, $content);

        $this->assertEquals($id, $file->getId());
        $this->assertEquals($filename, $file->getFilename());
        $this->assertEquals($content, $file->getContent());
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testSettersAndGetters($id, $filename, $content)
    {
        $file = new File(1, 'test.txt', 'test');

        $file->setFilename($filename);
        $file->setContent($content);

        $this->assertEquals($filename, $file->getFilename());
        $this->assertEquals($content, $file->getContent());
    }

    public function parameterProvider()
    {
        return [
            [1, null, 'test'],
            [1, '', 'test2'],
            [1, 'test', 'test3'],
            [1, 'test.txt', 'test4'],
            [1, '.test', 'test5']
        ];
    }
}
