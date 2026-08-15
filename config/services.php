<?php

return [
    'mail' => [
        'domain' => env('MAILGUN_DOMAIN'),
    ],

    'anthropic' => [
        'key' => env('ANTHROPIC_API_KEY'),
        'model' => env('ANTHROPIC_MODEL', 'claude-3-5-haiku-20241022'),
    ],
];
