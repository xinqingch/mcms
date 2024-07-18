<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=mcms',
    'username' => 'root',
    'password' => 'softstudy',
    'charset' => 'utf8mb4',
    'tablePrefix' => 'mo_',
    'emulatePrepare'=>true,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
