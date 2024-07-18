<?php
/**
 * Created by PhpStorm.
 * User: xinqi
 * Date: 2020-12-01
 * Time: 19:32
 */
return [
    'enablePrettyUrl' => true,
    'showScriptName' => true,
    'rules' => [
        'POST <module:\w+>/<controller:[\w-]+>s'           => '<module>/<controller>/create',
        '<module:\w+>/<controller:[\w-]+>s'                => '<module>/<controller>/index',
        'PUT <module:\w+>/<controller:[\w-]+>/<id:\d+>'    => '<module>/<controller>/update',
        'DELETE <module:\w+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/delete',
        'DELETE <module:\w+>/<controller:[\w-]+>' => '<module>/<controller>/delete',
        'GET <module:\w+>/<controller:[\w-]+>/<id:\d+>'    => '<module>/<controller>/view',
        '<module:\w+>/<controller:[\w-]+>/<action:[\w-]+>'                => '<module>/<controller>/<action>',
        '<module:\w+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>'                => '<module>/<controller>/<action>',
    ],
];