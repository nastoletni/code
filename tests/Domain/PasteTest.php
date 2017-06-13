<?php

namespace Nastoletni\Code\Domain;

use PHPUnit\Framework\TestCase;

class PasteTest extends TestCase
{
    /**
     * @dataProvider parametersProvider
     */
    public function testConstructorAndGetters($id, $title, $createdAt)
    {
        $paste = new Paste($id, $title, $createdAt);

        $this->assertEquals($id, $paste->getId());
        $this->assertEquals($title, $paste->getTitle());
        $this->assertEquals($createdAt, $paste->getCreatedAt());
        $this->assertEmpty($paste->getFiles());
    }

    /**
     * @dataProvider parametersProvider
     */
    public function testSettersAndGetters($id, $title, $createdAt)
    {
        $paste = new Paste(
            $this->createMock(Paste\Id::class),
            'test',
            new \DateTime()
        );

        $paste->setTitle($title);
        $paste->setCreatedAt($createdAt);

        $this->assertEquals($title, $paste->getTitle());
        $this->assertEquals($createdAt, $paste->getCreatedAt());
    }

    public function parametersProvider()
    {
        return [
            [
                $this->createMock(Paste\Id::class),
                'Example',
                new \DateTime(),
            ],
            [
                $this->createMock(Paste\Id::class),
                '',
                new \DateTime('+1 day'),
            ],
            [
                $this->createMock(Paste\Id::class),
                null,
                new \DateTime('-1 year'),
            ],
        ];
    }

    public function testAddingFile()
    {
        $paste = new Paste(
            $this->createMock(Paste\Id::class),
            'test',
            new \DateTime()
        );

        $file = $this->createMock(File::class);
        $paste->addFile($file);

        $this->assertContains($file, $paste->getFiles());
    }
}
