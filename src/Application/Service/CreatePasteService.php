<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Service;

use Nastoletni\Code\Application\Crypter\PasteCrypter;
use Nastoletni\Code\Application\Generator\RandomIdGenerator;
use Nastoletni\Code\Domain\File;
use Nastoletni\Code\Domain\Paste;
use Nastoletni\Code\Domain\PasteRepository;

class CreatePasteService
{
    /**
     * @var PasteRepository
     */
    private $pasteRepository;

    /**
     * @var PasteCrypter
     */
    private $pasteCrypter;

    /**
     * CreatePasteService constructor.
     *
     * @param PasteRepository $pasteRepository
     * @param PasteCrypter $pasteCrypter
     */
    public function __construct(PasteRepository $pasteRepository, PasteCrypter $pasteCrypter)
    {
        $this->pasteRepository = $pasteRepository;
        $this->pasteCrypter = $pasteCrypter;
    }

    /**
     * Creates Paste and File entities populating it with unique id and then
     * saves it to repository.
     *
     * @param array $data
     * @return CreatePastePayload
     */
    public function handle(array $data): CreatePastePayload
    {
        $encryptionKey = mb_substr(hash('sha256', random_bytes(256 / 8)), 32);

        do {
            $paste = new Paste(
                RandomIdGenerator::nextId(),
                $data['title'],
                new \DateTime()
            );

            foreach ($data['content'] as $i => $content) {
                $name = $data['name'][$i];

                $paste->addFile(new File($name, $content));
            }

            $this->pasteCrypter->encrypt($paste, $encryptionKey);

            $alreadyUsed = false;
            try {
                $this->pasteRepository->save($paste);
            } catch (Paste\AlreadyExistsException $e) {
                $alreadyUsed = true;
            }
        } while ($alreadyUsed);

        return new CreatePastePayload($paste, $encryptionKey);
    }
}
