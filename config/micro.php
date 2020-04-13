<?php

return [
    'app'   => [
        'id'        => 2,
        'secret'    => 'xxx',
        'redirect_uri'=> ''
    ],
    'url'   => [
        'auth'          => 'https://accounts.rumahkepemimpinan.org',
        'notification'  => 'http://localhost:8002',
        'auth_path'     => ''
    ],
    'endpoint'=> [
        'profile'   => '/api/v1/profile',
        'app_check' => '/api/v1/app-check'
    ]
];