<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'ADmad/JwtAuth' => $baseDir . '/vendor/admad/cakephp-jwt-auth/',
        'ApiSync' => $baseDir . '/plugins/ApiSync/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakeDC/Auth' => $baseDir . '/vendor/cakedc/auth/',
        'CakeDC/Users' => $baseDir . '/vendor/cakedc/users/',
        'Calendar' => $baseDir . '/plugins/Calendar/',
        'Cors' => $baseDir . '/vendor/ozee31/cakephp-cors/',
        'Crud' => $baseDir . '/vendor/friendsofcake/crud/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'EmailQueue' => $baseDir . '/plugins/EmailQueue/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Muffin/Footprint' => $baseDir . '/vendor/muffin/footprint/'
    ]
];