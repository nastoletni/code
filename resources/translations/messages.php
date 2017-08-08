<?php

return [
    'validator' => [
        'title' => [
            'not_null' => 'Title is required'
        ],
        'name' => [
            'not_null' => 'Name is required'
        ],
        'content' => [
            'not_blank' => 'Content is required'
        ]
    ]
];