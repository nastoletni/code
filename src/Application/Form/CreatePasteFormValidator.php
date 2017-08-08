<?php

declare(strict_types=1);

namespace Nastoletni\Code\Application\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class CreatePasteFormValidator
{
    /**
     * Self fabric method just for convenience.
     *
     * @return CreatePasteFormValidator
     */
    public static function create(): CreatePasteFormValidator
    {
        return new static();
    }

    /**
     * CreatePasteValidator constructor.
     */
    private function __construct()
    {
    }

    /**
     * Validates given data to comply with entity requirements.
     *
     * @param array $data
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'title' => new Assert\NotNull(['message' => 'validator.title.not_null']),
            'name'  => new Assert\All([
                new Assert\NotNull(['message' => 'validator.name.not_null']),
            ]),
            'content' => new Assert\All([
                new Assert\NotBlank(['message' => 'validator.content.not_blank']),
            ]),
        ]);

        return $validator->validate($data, $constraint);
    }
}
