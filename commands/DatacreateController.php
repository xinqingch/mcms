<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use Yii;
use app\models\Helper;
use app\models\DataCache;
use app\models\Adminer;

/**
 * 用于检测导入数据
 * Class DatacreateController
 * @package app\commands
 */
class DatacreateController extends Controller
{

    public function actionIndex()
    {

        $tabname =['mo_analysis_phone'];
        foreach ($tabname as $v){
                $DataCache = new DataCache();
                //$DataCache->user = $user;
                $DataCache->keyPrefix='create';
                $DataCache->tabname = $v;
                $newdata = $DataCache->getCache();
                var_dump($newdata);
                $check = $DataCache->checkIns();
                if($check==false){
                    $count = count($newdata);
                    $DataCache->batchInsert($newdata, $count);
                }

        }

    }
}
