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
use app\models\Adminer;
use app\models\Setting;

class AdminController extends Controller
{
    public $adminId;
    public $adminname;
    public $admiface;
    public function beforeAction($action)
    {

        $this->layout = './main';
        if (Yii::$app->admin->isGuest) {
            return $this->redirect(Yii::$app->admin->loginUrl)->send();
        }else{
            //取管理员信息
            $admininfo = Yii::$app->admin->identity;

            $this->adminname =$admininfo->attributes['username'];
            $this->adminId = $admininfo->attributes['adminerId'];
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
