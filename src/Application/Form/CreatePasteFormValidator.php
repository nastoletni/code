<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreatePasteFormValidator
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
        $this->validator = Validation::createValidator();
    }

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
     * Validates title.
     *
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    private function validateTitle(array $data): ConstraintViolationListInterface
    {
        return $this->validator->validate($data['title'], new Assert\NotBlank());
    }

    /**
     * Validates name fields.
     *
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    private function validateNames(array $data): ConstraintViolationListInterface
    {
        $constraintViolationList = new ConstraintViolationList();

        if (!isset($data['name'])) {
            // FIXME: This and below is here only because I'm too lazy to create custom constraint violation.
            throw new ValidatorException();
        }

        foreach ($data['content'] as $i => $content) {
            if (!isset($data['name'][$i])) {
                throw new ValidatorException(sprintf('No name with offset of %s has been sent.', $i));
            }

            $constraintViolationList->addAll(
                $this->validator->validate($data['name'][$i], new Assert\NotNull())
            );
        }

        return $constraintViolationList;
    }

    /**
     * Validates content fields.
     *
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    private function validateContents(array $data): ConstraintViolationListInterface
    {
        $constraintViolationList = new ConstraintViolationList();

        if (!isset($data['content'])) {
            // FIXME: This is here only because I'm too lazy to create custom constraint violation.
            throw new ValidatorException();
        }

        if (empty($data['content'])) {
            throw new ValidatorException('Content must not be empty.');
        }

        foreach ($data['content'] as $content) {
            $constraintViolationList->addAll(
                $this->validator->validate($content, new Assert\NotBlank())
            );
        }

        return $constraintViolationList;
    }

    /**
     * Validates given data to comply with entity requirements.
     * 
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        $violationList = new ConstraintViolationList();

        $violationList->addAll($this->validateTitle($data));
        $violationList->addAll($this->validateContents($data));
        $violationList->addAll($this->validateNames($data));

        return $violationList;
    }
}
