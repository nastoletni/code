<?php

return [
    'validator' => [
        'title' => [
            'not_null' => 'Pole tytuł jest wymagane'
        ],
        'name' => [
            'not_null' => 'Pole nazwa jest wymagane'
        ],
        'content' => [
            'not_blank' => 'Pole treść jest wymagane'
        ]
    ]
];