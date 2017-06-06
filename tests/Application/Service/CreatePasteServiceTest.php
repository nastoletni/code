<?php

namespace Nastoletni\Code\Application\Service;

use Nastoletni\Code\Application\Service\CreatePasteService;
use Nastoletni\Code\Domain\Paste;
use Nastoletni\Code\Domain\Paste\NotExistsException;
use Nastoletni\Code\Domain\PasteRepository;
use PHPUnit\Framework\TestCase;

class CreatePasteServiceTest extends TestCase
{
    public function testHandlingSavesToRepository()
    {
        $pasteRepositoryMock = $this->createMock(PasteRepository::class);
        $pasteRepositoryMock
            ->expects($this->once())
            ->method('save');

        $createPasteService = new CreatePasteService($pasteRepositoryMock);

        $createPasteService->handle($this->constructorParameters());
    }

    public function testHandlingPassesOnAlreadyExistsException()
    {
        $pasteRepository = new class implements PasteRepository {
            private $thrown = false;

            public function getById(Paste\Id $id): Paste
            {
                return null;
            }

            public function save(Paste $paste): void
            {
                if (false === $this->thrown) {
                    $this->thrown = true;

                    throw new Paste\AlreadyExistsException();
                }
            }
        };

        $createPasteService = new CreatePasteService($pasteRepository);
        $createPasteService->handle($this->constructorParameters());
        $createPasteService->handle($this->constructorParameters());

        // Service did not throw any exception, it's ok then
        $this->assertTrue(true);
    }

    public function testResultMatchesInput()
    {
        $createPasteService = new CreatePasteService($this->createMock(PasteRepository::class));

        $params = $this->constructorParameters();

        $paste = $createPasteService->handle($params);

        $this->assertEquals($params['title'], $paste->getTitle());
        $this->assertEquals($params['name'][0], $paste->getFiles()[0]->getFilename());
        $this->assertEquals($params['content'][0], $paste->getFiles()[0]->getContent());
    }

    private function constructorParameters()
    {
        return [
            'title' => 'Test',
            'name' => [
                'test.txt'
            ],
            'content' => [
                'Lorem ipsum dolor'
            ]
        ];
    }
}
