<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Service;

use Nastoletni\Code\Domain\Paste;

class CreatePastePayload
{
    /**
     * @var Paste
     */
    private $paste;

    /**
     * @var string
     */
    private $encryptionKey;

    /**
     * CreatePastePayload constructor.
     * @param Paste $paste
     * @param string $encryptionKey
     */
    public function __construct(Paste $paste, string $encryptionKey)
    {
        $this->paste = $paste;
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * @return Paste
     */
    public function getPaste(): Paste
    {
        return $this->paste;
    }

    /**
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }
}
