<?php
declare(strict_types=1);

namespace Nastoletni\Code\Infrastructure;

use Nastoletni\Code\Application\Crypter\CrypterException;
use Nastoletni\Code\Application\Crypter\PasteCrypter;
use Nastoletni\Code\Domain\Paste;

class AES256Crypter implements PasteCrypter
{
    private const CIPHER = 'aes-256-cbc';

    /**
     * {@inheritdoc}
     */
    public function encrypt(Paste &$paste, string $key): void
    {
        $key = $this->keyToEncryptionKey($key);

        foreach ($paste->getFiles() as $file) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(static::CIPHER));

            $encrypted = openssl_encrypt(
                $file->getContent(),
                static::CIPHER,
                $key,
                0,
                $iv
            );
            $iv = base64_encode($iv);

            $file->setContent($encrypted . ':' . $iv);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt(Paste &$paste, string $key): void
    {
        $key = $this->keyToEncryptionKey($key);

        foreach ($paste->getFiles() as $file) {
            [$encrypted, $iv] = explode(':', $file->getContent());

            $iv = base64_decode($iv);
            $decrypted = openssl_decrypt(
                $encrypted,
                static::CIPHER,
                $key,
                0,
                $iv
            );

            $file->setContent($decrypted);
        }
    }

    private function keyToEncryptionKey(string $key): string
    {
        return mb_substr(sha1($key, true), 0, 32);
    }
}
