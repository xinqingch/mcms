<?php

namespace app\modules\v1\controllers;

use app\models\Helper;
use yii\web\Controller;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //Yii::$app->cache->flush();
        Helper::results(0,'',[
            ['id'=>2, 'title'=>'a'],
            ['id'=>3, 'title'=>'b'],
        ], 'default');
    }

    /**
     * 创建方法
     */
    public function actionCreate() {
        Helper::results(0,'',Yii::$app->request->post(), 'post');
    }

    /**
     * 更新方法
     */
    public function actionUpdate() {
        Helper::results(0,'',Yii::$app->request->post(), 'put');
    }

    /**
     * 删除方法
     */
    public function actionDelete() {
        Helper::results(0,'',Yii::$app->request->get(), 'delete');
    }

    /**
     * 查看方法
     */
    public function actionView() {
        Helper::results(0,'',Yii::$app->request->get(), 'view');
    }
}
