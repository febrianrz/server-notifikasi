<?php

return [
    'app'   => [
        'id'        => 2,
        'secret'    => 'xxx',
        'redirect_uri'=> '',
        'auth_path'     => ''
    ],
    'url'   => [
        'auth'          => 'https://accounts.rumahkepemimpinan.org',
        'notification'  => 'https://apis.rumahkepemimpinan.org/notifikasi/public',
    ],
    'endpoint'=> [
        'profile'   => '/api/v1/profile',
        'app_check' => '/api/v1/app-check'
    ]
];
