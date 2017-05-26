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
            Paste\Id::createFromBase10((int) $data[0]['id']),
            empty($data[0]['title']) ? null : $data[0]['title'],
            new DateTime($data[0]['created_at'])
        );

        foreach ($data as $file) {
            $file = new File(
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
        $pasteRequiredFields = ['id', 'title', 'created_at'];
        $fileRequiredFields = ['filename', 'content'];

        foreach ($pasteRequiredFields as $pasteRequiredField) {
            if (!array_key_exists($pasteRequiredField, $data[0])) {
                throw new InvalidDataException(sprintf(
                    'Given data has to have \'%s\' key.',
                    $pasteRequiredField
                ));
            }
        }

        foreach ($data as $file) {
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
