<?php

return [
    'auto-docblocks' => [
        'enabled' => env('AUTO_MODEL_DOCBLOCKS', true),
        'options' => [
            '--write'       => true,
            '--smart-reset' => true,
        ],
    ],
    'auto-generate' => [
        'enabled' => env('AUTO_IDE_HELPER_GENERATE', true),
    ],
    'auto-meta' => [
        'enabled' => env('AUTO_IDE_HELPER_META', true),
    ]
];
