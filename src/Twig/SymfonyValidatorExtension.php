<?php
declare(strict_types=1);

namespace Nastoletni\Code\Twig;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Twig_SimpleFunction;

class SymfonyValidatorExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('error', [$this, 'error'])
        ];
    }

    /**
     * Yields all error messages from given field.
     *
     * @param string $field
     * @param ConstraintViolationListInterface|null $errors
     * @return iterable
     */
    public function error(string $field, ?ConstraintViolationListInterface $errors): iterable
    {
        if (is_null($errors)) {
            return;
        }

        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            if ($error->getPropertyPath() == $field) {
                yield $error->getMessage();
            }
        }
    }
}
