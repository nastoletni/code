<?php
declare(strict_types=1);

namespace Nastoletni\Code\Infrastructure;

use Nastoletni\Code\Application\Crypter\CrypterException;
use Nastoletni\Code\Application\Crypter\PasteCrypter;
use Nastoletni\Code\Domain\Paste;

class AES256Crypter implements PasteCrypter
{
    private const CIPHER = 'AES-256-CBC';

    /**
     * {@inheritdoc}
     */
    public function encrypt(Paste &$paste, string $key): void
    {
        foreach ($paste->getFiles() as $file) {
            // Generate initialization vector.
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(static::CIPHER));

            $encryptedContent = openssl_encrypt(
                'valid' . $file->getContent(),
                static::CIPHER,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            if (false === $encryptedContent) {
                throw new CrypterException('OpenSSL error: ' . openssl_error_string());
            }

            // Append initialization vector so we would be able to decrypt it later.
            $file->setContent($encryptedContent . ':' . $iv);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt(Paste &$paste, string $key): void
    {
        foreach ($paste->getFiles() as $file) {
            // Retrieve initialization vector from the encrypted content.
            [$content, $iv] = explode(':', $file->getContent());

            $content = openssl_decrypt(
                $content,
                static::CIPHER,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            if (false === $content) {
                throw new CrypterException('OpenSSL error: ' . openssl_error_string());
            }

            if ('valid' != substr($content, 0, 5)) {
                // Throws because provided key is invalid, but in fact it can happen due
                // to wrongly saved data, e.g. data put by hand into database.
                throw new CrypterException();
            }

            $file->setContent(preg_replace('/^valid/', '', $content));
        }
    }
}
