<?php

namespace Nastoletni\Code\Application\Form;

use PHPUnit\Framework\TestCase;

class CreatePasteFormValidatorTest extends TestCase
{
    public function testFabricMethod()
    {
        $this->assertInstanceOf(CreatePasteFormValidator::class, CreatePasteFormValidator::create());
    }

    /**
     * @dataProvider validationCasesProvider
     */
    public function testValidation($data, $errorsCount)
    {
        $validator = CreatePasteFormValidator::create();

        $errors = $validator->validate($data);

        $this->assertCount($errorsCount, $errors);
    }

    public function validationCasesProvider()
    {
        return [
            [
                [
                    'title' => 'Foobar',
                ],
                2,
            ],
            [
                [
                    'title'   => 'Foobar',
                    'content' => [
                        'test',
                    ],
                ],
                1,
            ],
            [
                [
                    'title' => 'Foobar',
                    'name'  => [
                        '',
                    ],
                    'content' => [
                        'Test content',
                    ],
                ],
                0,
            ],
            [
                [
                    'title' => 'Test',
                    'name'  => [
                        '',
                        '',
                    ],
                    'content' => [
                        'Test',
                        'Another test',
                    ],
                ],
                0,
            ],
            [
                [
                    'title' => '',
                    'name'  => [
                        '',
                    ],
                    'content' => [
                        'Test',
                    ],
                ],
                0,
            ],
            [
                [
                    'title' => '',
                    'name'  => [
                        '',
                    ],
                    'content' => [
                        '',
                    ],
                ],
                1,
            ],
            [
                [
                    'title' => 'Title',
                    'name'  => [
                        '',
                        '',
                    ],
                    'content' => [
                        'Test',
                        'Foobar',
                    ],
                ],
                0,
            ],
        ];
    }
}
