<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application;

use DateTime;
use Nastoletni\Code\Domain\File;
use Nastoletni\Code\Domain\Paste;

class PasteMapper
{
    /**
     * Maps array to Paste entity.
     *
     * @param array $data Associative array of paste fields.
     * @return Paste
     */
    public function map(array $data): Paste
    {
        $this->validateData($data);

        $paste = new Paste(
            Paste\Id::createFromBase10((int) $data['id']),
            empty($data['title']) ? null : $data['title'],
            new DateTime($data['created_at'])
        );

        foreach ($data['files'] as $file) {
            $file = new File(
                (int) $file['id'],
                empty($file['filename']) ? null : $file['filename'],
                $file['content']
            );

            $paste->addFile($file);
        }

        return $paste;
    }

    /**
     * Checks whether given data is valid.
     *
     * @param array $data
     * @throws InvalidDataException when data is invalid.
     */
    private function validateData(array $data): void
    {
        $pasteRequiredFields = ['id', 'title', 'created_at', 'files'];
        $fileRequiredFields = ['id', 'filename', 'content'];

        foreach ($pasteRequiredFields as $pasteRequiredField) {
            if (!array_key_exists($pasteRequiredField, $data)) {
                throw new InvalidDataException(sprintf(
                    'Given data has to have \'%s\' key.',
                    $pasteRequiredField
                ));
            }
        }

        if (empty($data['files'])) {
            throw new InvalidDataException('Given data don\'t have any files.');
        }

        foreach ($data['files'] as $file) {
            foreach ($fileRequiredFields as $fileRequiredField) {
                if (!array_key_exists($fileRequiredField, $file)) {
                    throw new InvalidDataException(sprintf(
                        'Given data\'s files have to have \'%s\' key.',
                        $fileRequiredField
                    ));
                }
            }
        }
    }
}