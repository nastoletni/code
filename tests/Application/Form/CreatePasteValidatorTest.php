<?php

namespace Nastoletni\Code\Application\Form;

use Nastoletni\Code\Application\Form\CreatePasteValidator;
use PHPUnit\Framework\TestCase;

class CreatePasteValidatorTest extends TestCase
{
    public function testFabricMethod()
    {
        $this->assertInstanceOf(CreatePasteValidator::class, CreatePasteValidator::create());
    }

    /**
     * @dataProvider validationCasesProvider
     * @
     */
    public function testValidation($data, $errorsCount)
    {
        $this->markTestIncomplete('TODO: Make validation work!');

        $validator = CreatePasteValidator::create();
        $errors = $validator->validate($data);

        $this->assertCount($errorsCount, $errors);
    }

    public function validationCasesProvider()
    {
        return [
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
            ]
        ];
    }
}
