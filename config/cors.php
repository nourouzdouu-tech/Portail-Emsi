<?php

return [
    'paths' => ['api/*', 'storage/*', 'media/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'], // Remplacez '*' par vos domaines en production (ex: ['http://localhost:3000'])
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];