<?php

namespace app\modules\v1\controllers;
use app\components\GeminApi;
use Yii;
use app\models\Helper;
use yii\web\Controller;

/**
 * Default controller for the `v1` module
 */
class GeminController extends Controller
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
        $post =['contents'=>[
                0=>[
                    'parts'=>[
                        0=>[
                            'text'=>$data['content']
                        ]
                    ]
                ]

            ],
            'user'=>$data['username'],
            'asins'=>$data['asins']
        ];
        //$c = '{"contents":[{"parts":[{"text":"Explain how AI works"}]}]}';
        //dump(json_encode($post));
        //dump(json_decode($c,true));exit;
        $config = ['apikey'=>'AIzaSyATUcwumTunfAzcCz6TUdBBjo4XSXFIoq4','apimodel'=>'gemini-1.5-flash-latest'];
       $api = new GeminApi($config);
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
