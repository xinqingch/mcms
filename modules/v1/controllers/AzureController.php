<?php

namespace app\modules\v1\controllers;
use Yii;
use app\components\AzureApi;
use app\models\Helper;
use yii\web\Controller;

/**
 * Default controller for the `v1` module
 */
class AzureController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $data = Yii::$app->request->post();
        if(empty($data['content'])||empty($data['username'])){
            Helper::results(1001,'传参错误',$data, 'post');
        }
        $post =['messages'=>
            [
                [
                    "role"=>"system",
                    "content"=>"您是一位亚马逊运营分析师",
                    ],
                [
                    "role"=>"user",
                    "content"=>$data['content'],
                ]
            ],
            'user'=>$data['username']
        ];
        $config = ['apikey'=>'3cd34861f0d54b319842e03ac77d4d5f','apiname'=>'analysisapi3','apimodel'=>'gpt-35-turbo'];
       $api = new AzureApi($config);
       $results = $api->chat($post);
        //Yii::$app->cache->flush();
        Helper::results(0,'',$results, 'default');
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
