<?php

namespace app\modules\madmin\controllers;


use app\models\AnalysisSetting;
use app\models\Helper;
use yii;
use app\controllers\AdminController;
use app\models\Setting;
use app\components\message\MessageStorage;
/**
 * 配置控制器
 */
class SettingController extends AdminController
{
    
    /**
     *基本配置
     * @return string
     */
    public function actionIndex()
    {

        if (Yii::$app->request->isPost) {
            $model = new Setting();
            $settingdata = Yii::$app->request->post('setting');
            //dump($settingdata['h10_cookie']);exit;
            foreach ($settingdata as $key=>$value){
                if($key=='h10_token'){//把token写入缓存
                    $md5 = md5($settingdata['h10_cookie']);
                    $pattern = '/ajs_user_id=(\d+)/';
                    if (preg_match($pattern, $settingdata['h10_cookie'], $matches)) {
                        // 匹配成功，$matches[1]包含ajs_user_id的值
                        $accountId = $matches[1];
                    } else {
                        // 匹配失败
                        $accountId ='';
                    }
                    $cachename = 'helium10Token'.$accountId.$md5;
                    Yii::$app->cache->set($cachename,$value,3600*3);//token保存6小时
                }
                $model->up($key,$value);
            }
        }
        $model = Setting::getCache();
        return $this->render('index',['model'=>$model]);
    }

    public function actionMail(){
        if (Yii::$app->request->isPost) {
            $model = new Setting();
            $settingdata = Yii::$app->request->post('mailconfig');
            if(!empty($settingdata)){
                $settingdata = serialize($settingdata);
                $model->up('mailconfig',$settingdata);
            }

        }
        $model = Setting::getCache();
        $mailconfig = unserialize($model['mailconfig']);
        return $this->render('mail',['mailconfig'=>$mailconfig]);
    }

    /**
     * Asin配置
     * @return void
     */
    public function actionAsin(){
        if (Yii::$app->request->isPost) {
            $model = new Setting();
            $settingdata = Yii::$app->request->post('asinconfig');
            $point = Yii::$app->request->post('point');
            $api = Yii::$app->request->post('api');
            $aiapi = Yii::$app->request->post('aiapi');
            //dump($api);exit;
            if(!empty($settingdata)){
                $settingdata = serialize($settingdata);
                $model->up('asinconfig',$settingdata);
                $model->up('asinpoint',$point);
                $model->up('asinapi',$api);
                $model->up('aiapi',$aiapi);
            }

        }
        $model = Setting::getCache();
        $asinconfig = unserialize($model['asinconfig']);
        //取所有算法
        $ModelA = AnalysisSetting::find()->orderBy('settingId DESC')->all();

        //dump($asinconfig);
        return $this->render('asinsetting',['asinconfig'=>$asinconfig,'point'=>$model['asinpoint'],'api'=>$model['asinapi'],'aiapi'=>$model['aiapi'],'list'=>$ModelA]);
    }

    /**
     * Asin配置
     * @return void
     */
    public function actionAiapi(){
        if (Yii::$app->request->isPost) {
            $model = new Setting();
            $openaiapidata = Yii::$app->request->post('openaiapi');
            $geminapi = Yii::$app->request->post('geminapi');
            $aiapi = Yii::$app->request->post('aiapi');
            //dump($api);exit;
            if(!empty($openaiapidata)){
                $model->up('openaiapi', serialize($openaiapidata));
                $model->up('geminapi',serialize($geminapi));
                $model->up('aiapi',$aiapi);
            }

        }
        $model = Setting::getCache();
        $openaiapi = unserialize($model['openaiapi']);
        $geminapi = unserialize($model['geminapi']);

        //dump($asinconfig);
        return $this->render('aiapi',['openaiapi'=>$openaiapi,'geminapi'=>$geminapi,'aiapi'=>$model['aiapi']]);
    }


    /**
     * 另存算法
     * @return void
     */
    public function actionAlgorithm(){
        if (Yii::$app->request->isPost) {
            $model = new Setting();
            $Algorithm=[];
            $title = Yii::$app->request->post('title');
            $title_en = Yii::$app->request->post('title_en');
            if(empty($title)||empty($title_en)){
                Helper::results(1,'方案名或方案英文名没有填写','方案名或方案英文名没有填写', 'post');
            }
            //判断是否英文数字组成
            if (!preg_match('/^[a-zA-Z0-9]+$/', $title_en)) {
                Helper::results(2,'方案英文名只能英文或数字组成','方案英文名只能英文或数字组成', 'post');
            }
            $type = Yii::$app->request->post('type',0);
            $isDefault = Yii::$app->request->post('isDefault',0);
            $Algorithm['asinconfig'] = Yii::$app->request->post('asinconfig');
            $Algorithm['point'] = Yii::$app->request->post('point');
            //dump(Yii::$app->request->post());
            if(!empty($Algorithm['asinconfig'])){
                $settingdata = serialize($Algorithm['asinconfig']);
                $model->up('asinconfig',$settingdata);
                $model->up('asinpoint',$Algorithm['point']);
            }
            $ModelA = new AnalysisSetting();
            $ModelAdata = [
                'title'=>$title,
                'title_en'=>$title_en,
                'type'=>$type,
                'isDefault'=>$isDefault,
                'content'=>serialize($Algorithm),
                ];
            $re =$ModelA->add($ModelAdata);
            //dump($re);
            if($re['state']==true){
                Helper::results(0,'保存方案成功',$re, 'post');
            }else{
                Helper::results(1,'保存方案失败',$re['data'], 'post');
            }
        }
    }
    public function actionSetdefault($id){
            $model = new AnalysisSetting();
            $return = $model->setDefault($id);
            $this->redirect('asin');

    }

    /**
     * 删除算法方案
     * @param $id
     * @return void
     */
    public function actionAsindel($id){
        $model = AnalysisSetting::deleteAll('settingId=:id',[':id'=>$id]);
        $this->redirect('asin');

    }


    /**
     * 发送测试邮件
     */
    public function actionTestmail(){
        if (Yii::$app->request->isPost) {
            $mail = Yii::$app->request->post('mail');
            $model = new MessageStorage('您的验证码是');
            $model->title = '验证码测试';
            $model->body = $model->sendTemplate('reg',['captcha'=>rand(0,999)]);
            $model->type='mail';
            if(!empty($mail)){
                $data = $model->send($mail);
            }

        }
        if($data){
            Helper::results(0,'发送成功','发送成功', 'post');
        }else{
            Helper::results(1,'发送失败','发送成功', 'post');
        }
    }



    
}
