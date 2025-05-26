<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
           
            'cookieValidationKey' => '6zPUu-H6M2MflUTAp2jL20mfot3dpZId',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            // 'class' => \yii\symfonymailer\Mailer::class,
            // 'viewPath' => '@app/mail',
            // // send all mails to a file by default.
            // 'useFileTransport' => true,
              
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => true, 
   
        ],
                'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'appointment/book' => 'appointment/book',
                  'doctor/dashboard' => 'doctor/dashboard',
            'doctor/calendar/<doctor_id:\d+>' => 'doctor/calendar',
            'doctor/book-appointment/<doctor_id:\d+>' => 'doctor/book-appointment',
            'doctor/view-appointments' => 'doctor/view-appointments',
            'doctor/schedule' => 'doctor/schedule',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',   
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

    ],
    'params' => $params,
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
