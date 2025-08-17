<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

    'components' => [
        'paths' => [
            resource_path('views/components'),
        ],
    ],
];
