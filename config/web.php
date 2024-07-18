<?php
require __DIR__ . '/../common/GlobalFunctions.php';
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlmanage = require __DIR__ . '/url.php';

$config = [
    'id' => 'MSHOP',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@madmin'   => '@modules/madmin',
        '@analysis'   => '@modules/analysis',
        '@curtain'   => '@modules/curtain',
    ],
    'modules' => [
        'cms' => 'app\modules\cms\Module',
        'madmin' => 'app\modules\madmin\Module',
        'v1' => 'app\modules\v1\Module',
        'analysis' => 'app\modules\analysis\Module',
        'curtain' => 'app\modules\curtain\Module',
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'r3i8hUGEHIE43298hfe9ur32GHI32ew98h',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'=>['/analysis/login'],//定义后台默认登录界面[权限不足跳到该页]
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Adminer',
            'enableAutoLogin' => true,
            'loginUrl'=>['/madmin/login'],//定义后台默认登录界面[权限不足跳到该页]
            'identityCookie' => ['name' => '__admin_identity', 'httpOnly' => true],
            'idParam' => '__adminId'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',  //每种邮箱的host配置不一样
                'username' => 'girlxy@girlxy.com',
                'password' => 'softstudy',
                'port' => '465',
                'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['service@066810.com'=>'信裕传媒']
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'adm' => 'adm.php',
                        'app/error' => 'error.php',
                    ],
                ],
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
        'urlManager' => $urlmanage,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.2.*'],
        'generators' => [
            'model' => [ //生成器名称
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [ //设置我们自己的模板
                    //模板名 => 模板路径
                    'model' => '@app/giitemp/default',
                ]
            ]
        ],
    ];
}

return $config;
