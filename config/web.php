<?php

use app\components\request_parsers\DummyRequestParser;
use app\components\request_parsers\ForbiddenTypeRequestParser;
use app\modules\v1\Module;
use yii\rest\UrlRule;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'    => [
        'v1' => [
            'class' => Module::class,
        ],
    ],
    'components' => [
        'request'      => [
            'cookieValidationKey' => '688787d8ff144c502c7f5cffaafe2cc588d86079f9de88304c26b0cb99ce91c6',
            'parsers'             => [
                'application/x-www-form-urlencoded' => DummyRequestParser::class,
                '*'                                 => ForbiddenTypeRequestParser::class,
            ],
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [
                [
                    'class'      => UrlRule::class,
                    'controller' => ['v1/user'],
                    'except'     => ['index'],
                    'pluralize'  => false,
                ],
            ],
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
