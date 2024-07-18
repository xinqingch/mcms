<?php

namespace app\modules\madmin\controllers;


use app\components\point\PointStorage;
use app\models\Helper;
use app\models\MemberPermission;
use app\models\MemberPointLog;
use app\models\MemberRole;
use app\models\Nav;
use app\models\User;
use yii;
use app\controllers\AdminController;
use app\models\Adminer;
use app\components\message\MessageStorage;
use function GuzzleHttp\Psr7\str;

/**
 * 用户控制器
 */
class MemberController extends AdminController
{
    
    /**
     *用户列表
     * @return string
     */
    public function actionIndex()
    {
        $list = User::find()->all();
        return $this->render('index',['list'=>$list]);
    }

    public function actionCreate(){
        $model = new User();
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('User');
            $data['exptime'] = strtotime($data['exptime']);
            $model->attributes = $data;
            $checkname = $model::checkField('username',$data['username']);;
            if (!empty($checkname)){
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

        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg]);
    }

    public function actionEdit($id){
        $model = User::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('User');
            $data['exptime'] = strtotime($data['exptime']);
            //dump(array_filter($data));
            $model->attributes = array_filter($data);
            if(isset($data['password'])){
                $model->setPassword($data['password']);
                $model->generateAuthKey();
            }
            $re = $model->up($id,$data);
            if($re['state']){
                return $this->redirect('index');
                exit;
            }else{
                $errmsg = Helper::modelerror($re['data']);
            }

        }
        $model->exptime = date('Y-m-d',$model->exptime);
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg]);
    }

    /**
     * 删除管理员
     */
    public function actionDelete($id){
        $model = User::findOne($id);
        $data = $model->delete();
        if($data){
            return $this->redirect('index');
        }else{
            return $this->redirect('index');
        }
    }

    /**
     * 积分列表
     * @param $id
     * @return string
     */
    public function actionPointlist($id){
        $list = MemberPointLog::find()->where(['memberId'=>$id])->orderBy('inputtime DESC')->all();
        return $this->render('pointlist',['list'=>$list]);
    }

    /**
     * 会员角色
     * @return void
     */
    public function actionRole(){
            $list = MemberRole::find()->all();
        return $this->render('role',['list'=>$list]);
    }

    /**
     * 角色权限
     * @param $id
     * @return void
     */
    public function actionPermission($id){
        $MemberPermission = new MemberPermission();
        $Permissionlist = $MemberPermission->find()->where(['memberroleId'=>$id])->asArray()->all();
        $permission = array_column($Permissionlist, 'navId');
        $nav = new Nav();
        $memu = $nav->getALLMenu();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            //dump($permission);
            //dump($data['navId']);
            $delids = array_diff($permission,$data['navId']);//删除Id
            $addlids = array_diff($data['navId'],$permission);//添加Id
            //dump($addlids);exit;
            if($delids){//删除菜单
                $MemberPermission->deleteAll(['and',['memberroleId'=>$id],['in','navId',$delids]]);
            }
            if($addlids){//添加菜单
               foreach ($addlids as $v){
                   $adddata = ['memberroleId'=>$id,'navId'=>$v];
                   $MemberPermission->add($adddata);
               }
            }
            $this->redirect('/madmin/member/role');



        }
        return $this->render('permission',['permission'=>$permission,'memu'=>$memu]);
    }

    /**
     * 添加会员积分点数
     * @param $id 会员ID
     * @return void
     */
    public function actionPoint($id){

        if (Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('type');
            $point = Yii::$app->request->post('point');
            $model = new PointStorage();
            $data = $model->add($id,$type,0,$point,null,'后台修改');
            //dump($data);
            if($data){
                return $this->redirect('index');
            }
        }
        return $this->render('point');
    }



    
}
