<?php

namespace Nastoletni\Code\Application;

use DateTime;
use Nastoletni\Code\Infrastructure\Dbal\DbalPasteMapper;
use PHPUnit\Framework\TestCase;
use Nastoletni\Code\Application\InvalidDataException;

class DbalPasteMapperTest extends TestCase
{
    public function testMappingValidData()
    {
        $mapper = new DbalPasteMapper();

        $validData = [
            [
                'id' => 438643,
                'title' => null,
                'created_at' => '2017-05-25 20:33:54',
                'filename' => 'foo.php',
                'content' => '<?= "test"; ?>'
            ],
            [
                'id' => 438643,
                'title' => null,
                'created_at' => '2017-05-25 20:33:54',
                'filename' => '',
                'content' => 'test'
            ]
        ];

        $paste = $mapper->map($validData);

        $this->assertEquals(438643, $paste->getId()->getBase10Id());
        $this->assertNull($paste->getTitle());
        $this->assertEquals('2017-05-25 20:33:54', $paste->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertNotEmpty($paste->getFiles());
        $this->assertEquals('foo.php', $paste->getFiles()[0]->getFilename());
        $this->assertEquals('<?= "test"; ?>', $paste->getFiles()[0]->getContent());
        $this->assertNull($paste->getFiles()[1]->getFilename());
    }

    /**
     * @dataProvider invalidDataProvider
     * @expectedException \Nastoletni\Code\Application\InvalidDataException
     */
    public function testMappingThrowsExceptionWithInvalidData($data)
    {
        $mapper = new DbalPasteMapper();

        $mapper->map($data);
    }

    public function invalidDataProvider()
    {
        return [
            [[[
            ]]],
            [[[
                'id' => 1
            ]]],
            [[[
                'id' => 1,
                'title' => 'test'
            ]]],
            [[[
                'id' => 1,
                'title' => 'test',
                'created_at' => ''
            ]]],
            [[[
                'id' => 1,
                'title' => 'test',
                'created_at' => '',
                'filename' => 'test'
            ]]]
        ];
    }
}
