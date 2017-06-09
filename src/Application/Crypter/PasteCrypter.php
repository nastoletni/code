<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Crypter;

use Nastoletni\Code\Domain\Paste;

interface PasteCrypter
{
    /**
     * Encrypts some Paste's private fields.
     *
     * @param Paste $paste
     * @param string $key
     */
    public function encrypt(Paste &$paste, string $key): void;

    /**
     * Decrypts encrypted fields.
     *
     * @param Paste $paste
     * @param string $key
     * @throws CrypterException when given key is invalid.
     */
    public function decrypt(Paste &$paste, string $key): void;
}
