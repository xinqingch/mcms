<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\models\Helper;
use app\models\AnalysisAsins;
use app\models\AnalysisAsinsLog;
use yii\console\Controller;
use app\components\asinanalysis\AsinStorage;

/**
 * 更新接口数据
 * Class AsinpaiApiController
 * @package app\commands
 */
class AsinpaiapiController extends Controller
{

    public function actionIndex()
    {
        $nodata = AnalysisAsinsLog::find()->where(['status'=>0])->one();
        if($nodata){
            $AsinStorage = new AsinStorage();
            $asindata = $AsinStorage->find($nodata->asin->asins,$nodata->asin->region,100,$nodata->page);
            var_dump($nodata->asinid.'-'.$nodata->page);
        }else{
            echo 0;
        }

    }
}
