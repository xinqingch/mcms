<?php

namespace app\modules\madmin\controllers;


use app\models\Helper;
use app\models\Role;
use yii;
use app\controllers\AdminController;
use app\models\Adminer;
use app\components\message\MessageStorage;
/**
 * 配置控制器
 */
class AdminerController extends AdminController
{
    
    /**
     *管理员列表
     * @return string
     */
    public function actionIndex()
    {
        $where = ['state'=>Adminer::STATUS_ACTIVE,'isadmin'=>0];
        $list = Adminer::find()->select(['adminerId','roleId','username','login_time','login_ip','inputtime'])->where($where)->all();
        return $this->render('index',['list'=>$list]);
    }

    public function actionCreate(){
        $model = new Adminer();
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Adminer');
            $model->attributes = $data;
            $checkname = $model->findByUsername($data['username']);
            if($data['password']!=$data['repassword']) {
                $errmsg = '两次输入密码不相同，请重新输入';
            }elseif (!empty($checkname)){
                $errmsg = '已有相同的用户名，请重新输入';
            }else{
                $re = $model->add($data);
                if($re['state']){
                    return $this->redirect('index');
                    exit;
                }else{
                    $errmsg = Helper::modelerror($re['data']);
                }
            }

        }
        $roleoption = Role::listoption();
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg,'roleoption'=>$roleoption]);
    }

    public function actionEdit($id){
        $model = Adminer::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Adminer');
            $model->attributes = $data;
            if($data['password']!=$data['repassword']) {
                $errmsg = '两次输入密码不相同，请重新输入';
            }else{
                $re = $model->up($id,$data);
                if($re['state']){
                    return $this->redirect('index');
                    exit;
                }else{
                    $errmsg = Helper::modelerror($re['data']);
                }
            }

        }
        $roleoption = Role::listoption();
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg,'roleoption'=>$roleoption]);
    }

    /**
     * 删除管理员
     */
    public function actionDelete($id){
        $model = new Adminer();
        $data = $model->up($id,['state'=>0]);
        if($data['state']){
            Helper::results(0,'删除成功',$data['data'], 'post');
        }else{
            Helper::results(1,'删除失败',$data['data'], 'post');
        }
    }



    
}
