<?php

namespace Nastoletni\Code\Twig;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class SymfonyValidatorExtensionTest extends TestCase
{
    public function testGetFunctions()
    {
        $extension = new SymfonyValidatorExtension();
        /** @var \Twig_SimpleFunction $function */
        $function = $extension->getFunctions()[0];

        $this->assertInstanceOf(\Twig_SimpleFunction::class, $function);
        $this->assertEquals('error', $function->getName());
    }

    public function testErrorWithNull()
    {
        $extension = new SymfonyValidatorExtension();

        $this->assertCount(0, $extension->error('test', null));
    }

    public function testErrorWithViolationList()
    {
        $extension = new SymfonyValidatorExtension();
        $violationList = new ConstraintViolationList([
            new ConstraintViolation('test', 'test', [], null, 'foobar', ''),
        ]);

        $errors = $extension->error('foobar', $violationList);

        $this->assertContains('test', $errors);
        $this->assertCount(1, $errors);
    }
}
