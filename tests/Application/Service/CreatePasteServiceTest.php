<?php

namespace Nastoletni\Code\Application\Service;

use Nastoletni\Code\Application\Crypter\PasteCrypter;
use Nastoletni\Code\Domain\Paste;
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

        $createPasteService = new CreatePasteService(
            $pasteRepositoryMock,
            $this->createMock(PasteCrypter::class)
        );

        $createPasteService->handle($this->constructorParameters());
    }

    public function testHandlingEncryptsPaste()
    {
        $pasteCrypterMock = $this->createMock(PasteCrypter::class);
        $pasteCrypterMock
            ->expects($this->once())
            ->method('encrypt');

        $createPasteService = new CreatePasteService(
            $this->createMock(PasteRepository::class),
            $pasteCrypterMock
        );

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

        $createPasteService = new CreatePasteService(
            $pasteRepository,
            $this->createMock(PasteCrypter::class)
        );
        $createPasteService->handle($this->constructorParameters());
        $createPasteService->handle($this->constructorParameters());

        // Service did not throw any exception, it's ok then
        $this->assertTrue(true);
    }

    public function testResultMatchesInput()
    {
        $createPasteService = new CreatePasteService(
            $this->createMock(PasteRepository::class),
            $this->createMock(PasteCrypter::class)
        );

        $params = $this->constructorParameters();

        $payload = $createPasteService->handle($params);
        $paste = $payload->getPaste();

        $this->assertEquals($params['title'], $paste->getTitle());
        $this->assertEquals($params['name'][0], $paste->getFiles()[0]->getFilename());
        $this->assertEquals($params['content'][0], $paste->getFiles()[0]->getContent());

        $this->assertNotEmpty($payload->getEncryptionKey());
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
