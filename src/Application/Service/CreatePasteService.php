<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Service;

use Nastoletni\Code\Application\RandomIdGenerator;
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
     * CreatePasteService constructor.
     *
     * @param PasteRepository $pasteRepository
     */
    public function __construct(PasteRepository $pasteRepository)
    {
        $this->pasteRepository = $pasteRepository;
    }

    /**
     * Creates Paste and File entities populating it with unique id and then
     * saves it to repository.
     *
     * @param array $data
     * @return Paste
     */
    public function handle(array $data): Paste
    {
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

            $alreadyUsed = false;
            try {
                $this->pasteRepository->save($paste);
            } catch (Paste\AlreadyExistsException $e) {
                $alreadyUsed = true;
            }
        } while($alreadyUsed);

        return $paste;
    }
}
