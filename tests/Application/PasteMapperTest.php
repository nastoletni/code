<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 2017-05-25
 * Time: 20:29
 */

namespace Nastoletni\Code\Application;

use DateTime;
use PHPUnit\Framework\TestCase;
use Nastoletni\Code\Application\InvalidDataException;

class PasteMapperTest extends TestCase
{
    public function testMappingValidData()
    {
        $mapper = new PasteMapper();

        $validData = [
            'id' => 438643,
            'title' => null,
            'created_at' => '2017-05-25 20:33:54',
            'files' => [
                [
                    'id' => 15,
                    'filename' => 'foo.php',
                    'content' => '<?= "test"; ?>'
                ],
                [
                    'id' => 16,
                    'filename' => '',
                    'content' => 'test'
                ]
            ]
        ];

        $paste = $mapper->map($validData);

        $this->assertEquals(438643, $paste->getId()->getBase10Id());
        $this->assertNull($paste->getTitle());
        $this->assertEquals('2017-05-25 20:33:54', $paste->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertNotEmpty($paste->getFiles());
        $this->assertEquals(15, $paste->getFiles()[0]->getId());
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
        $mapper = new PasteMapper();

        $mapper->map($data);
    }

    public function invalidDataProvider()
    {
        return [
            [[
            ]],
            [[
                'id' => 1
            ]],
            [[
                'id' => 1,
                'title' => 'test'
            ]],
            [[
                'id' => 1,
                'title' => 'test',
                'created_at' => ''
            ]],
            [[
                'id' => 1,
                'title' => 'test',
                'created_at' => '',
                'files' => []
            ]],
            [[
                'id' => 1,
                'title' => 'test',
                'created_at' => '',
                'files' => [
                    [
                        'id' => 1
                    ]
                ]
            ]],
            [[
                'id' => 1,
                'title' => 'test',
                'created_at' => '',
                'files' => [
                    [
                        'id' => 1,
                        'filename' => 'test'
                    ]
                ]
            ]]
        ];
    }
}
