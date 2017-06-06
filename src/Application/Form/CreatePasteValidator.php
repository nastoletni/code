<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @todo: make this works
 */
class CreatePasteValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CreatePasteValidator constructor.
     */
    private function __construct()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
    }

    /**
     * Self fabric method just for convenience.
     *
     * @return CreatePasteValidator
     */
    public static function create(): CreatePasteValidator
    {
        return new static();
    }

    /**
     * Loads Symfony validator metadata.
     *
     * @param ClassMetadata $metadata
     */
    private static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('title', [
            new Assert\NotNull()
        ]);

        $metadata->addPropertyConstraint('name', new Assert\All([
            'constraints' => [
                new Assert\NotNull()
            ]
        ]));

        $metadata->addPropertyConstraint('content', new Assert\All([
            'constraints' => [
                new Assert\NotBlank()
            ]
        ]));
    }

    /**
     * Validates given data to comply with entity requirements.
     * 
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        return $this->validator->validate((object) $data);
    }
}
