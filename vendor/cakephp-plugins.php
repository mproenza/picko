<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'ADmad/I18n' => $baseDir . '/vendor/admad/cakephp-i18n/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'EmailQueue' => $baseDir . '/plugins/EmailQueue/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/'
    ]
];