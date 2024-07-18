<?php

namespace app\modules\v1\controllers;
use app\models\SystemLog;
use app\models\User;
use Yii;
use app\models\Helper;
use yii\web\Controller;
use app\components\SignatureService;

/**
 * Default controller for the `v1` module
 */
class OperationlogController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost){
            if(!isset($post['username'])){
                Helper::results(1002,'请提交用户名',$post, 'default');
            }
            if(!isset($post['url'])){
                Helper::results(1002,'请提交操作地址',$post, 'default');
            }
            if(!isset($post['signature'])){
                Helper::results(1002,'验证签名未提交',$post, 'default');
            }

            $check = SignatureService::verifySignature($post);
            if($check==false){
                Helper::results(1001,'您的签名不正确！',$post, 'default');
            }else{
                $user =User::findByUsername($post['username']);
                if(empty($user)){
                    Helper::results(1003,'您提交的用户不存在',$post, 'default');
                }
                $SystemLog = new SystemLog();
                $data =[
                    'memberId'=>$user['memberId'],
                    'url'=>$post['url'],
                    'data'=>$post['data'],
                    'inputtime'=>time(),
                ];
                $SystemLog->add($data);
                Helper::results(0,'数据已提交成功！',$post, 'default');
            }
        }else{
            Helper::results(1001,'未检测到数据提交！','', 'default');
        }


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
