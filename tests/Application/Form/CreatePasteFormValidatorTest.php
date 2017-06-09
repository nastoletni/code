<?php

namespace Nastoletni\Code\Application\Form;

use Nastoletni\Code\Application\Form\CreatePasteFormValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ValidatorException;

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

        /** Just because of my laziness @see CreatePasteFormValidator::validateContents */
        try {
            $errors = $validator->validate($data);
        } catch (ValidatorException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->assertCount($errorsCount, $errors);
    }

    public function validationCasesProvider()
    {
        return [
            [
                [
                    'title' => '',
                    'name' => [],
                    'content' => []
                ],
                2
            ],
            [
                [
                    'title' => 'Foobar',
                    'name' => [
                        ''
                    ],
                    'content' => [
                        'Test content'
                    ]
                ],
                0
            ],
            [
                [
                    'title' => 'Test',
                    'name' => [
                        '',
                        ''
                    ],
                    'content' => [
                        'Test',
                        'Another test'
                    ]
                ],
                0
            ],
            [
                [
                    'title' => '',
                    'name' => [
                        ''
                    ],
                    'content' => [
                        'Test'
                    ]
                ],
                1
            ],
            [
                [
                    'title' => '',
                    'name' => [
                        ''
                    ],
                    'content' => [
                        ''
                    ]
                ],
                2
            ],
            [
                [
                    'title' => 'Title',
                    'name' => [
                        ''
                    ],
                    'content' => [
                        'Test',
                        'Foobar'
                    ]
                ],
                1
            ]
        ];
    }
}
