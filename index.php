<?php
/**
 * 应用程序环境，可选：development,main,
 */
defined('APP_ENV') or define('APP_ENV','main');

// change the following paths if necessary
if (APP_ENV == 'main') {
	error_reporting(0);
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	$yii=dirname(__FILE__).'/lib/yii.php';
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
} else {
	$yii=dirname(__FILE__).'/lib/yii.php';
	error_reporting(7);
	// remove the following lines when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}
$config=dirname(__FILE__).'/protected/config/'.APP_ENV.'.php';
require_once('protected/globals.php');//加载全局函数库
require_once($yii);
Yii::createWebApplication($config)->run();