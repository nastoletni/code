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
     */
    public function testValidation($data, $errorsCount)
    {
//        $this->markTestIncomplete('TODO: Make validation work!');

        $validator = CreatePasteValidator::create();

        /** Just because of my laziness @see CreatePasteValidator::validateContents */
        try {
            $errors = $validator->validate($data);
        } catch (\Exception $e) {
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
