<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Helper;
use app\models\User;
use app\models\Setting;

class CurtainController extends Controller
{
    public $userId;
    public $username;
    public $userphone;
    public function beforeAction($action)
    {

        $this->layout = './main';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->loginUrl)->send();
        }else{
            //取管理员信息
            $userinfo = Yii::$app->user->identity;
            $this->userId = $userinfo->attributes['memberId'];
            $this->username =$userinfo->attributes['username'];
            $this->userphone = $userinfo->attributes['phone'];
        }

        return true;
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix"  => Setting::getStting('site_url'),//图片访问路径前缀
                    "imagePathFormat" => "/upload/{yyyy}/{mm}/{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
}
