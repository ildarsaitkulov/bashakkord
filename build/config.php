<?php

return [
    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'bashakkord',
            'user' => '{{db.user}}',
            'password' => '{{db.password}}'
        ],
       
    ],
    
    'domain' => '{{domain}}',
    'mail' => [
        'method' => 'smtp',
        'host' => 'server11.shneider-host.ru',
        'port' => 465,
        'secure' => 'ssl',
        'auth' => [
            'username' => 'support@bashakkord.ru',
            'password' => '{{mail.password}}',
        ],
        'sender' => 'BashAkkord'

    ],

];