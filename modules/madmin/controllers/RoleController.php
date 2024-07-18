<?php

namespace app\modules\madmin\controllers;


use app\models\Helper;
use app\models\Permission;
use app\models\Sysmenu;
use yii;
use app\controllers\AdminController;
use app\models\Role;
/**
 * 配置控制器
 */
class RoleController extends AdminController
{
    
    /**
     *管理员列表
     * @return string
     */
    public function actionIndex()
    {
        $where = ['state'=>Role::STATUS_ACTIVE];
        $list = Role::find()->select(['roleId','rolename','description','state'])->where($where)->all();
        return $this->render('index',['list'=>$list]);
    }

    public function actionCreate(){
        $model = new Role();
        $errmsg ='';
        $sysmenu = new Sysmenu();
        $menu = $sysmenu->getMenuOption();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Role');
            $permission = Yii::$app->request->post('permission');//权限

            $model->attributes = $data;
            $checkname = $model->checkField('rolename',$data['rolename'],);
            //dump($checkname);
            if ($checkname){
                $errmsg = '已有相同的用户名，请重新输入';
            }else{
                $re = $model->add($data);
                if($re['state']){
                    //添加成功后加入权限
                    $permodel = new Permission();
                    $s = $permodel->add($re['data']['roleId'],$permission);
                    //跳转到首页
                    return $this->redirect('index');
                    exit;
                }else{
                    $errmsg = Helper::modelerror($re['data']);
                }
            }

        }
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg,'menu'=>$menu,'perdata'=>'']);
    }

    public function actionEdit($id){
        $model = Role::findOne($id);
        $errmsg ='';
        $sysmenu = new Sysmenu();
        $menu = $sysmenu->getMenuOption();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Role');
            $permission = Yii::$app->request->post('permission');//权限
            $model->attributes = $data;
            $re = $model->save();
            if($re){
                $permodel = new Permission();
                $s = $permodel->add($id,$permission);
                    return $this->redirect('index');
                    exit;
            }else{
                    $errmsg = '修改失败';
            }
        }
        $Permission= new Permission();
        $perdata = $Permission->getRole($id);
        //dump($perdata);
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg,'menu'=>$menu,'perdata'=>$perdata]);
    }

    /**
     * 删除角色
     */
    public function actionDelete($id){
        $model = new Role();
        $data = $model->up($id,['state'=>0]);
        if($data['state']){
            Helper::results(0,'删除成功',$data['data'], 'post');
        }else{
            Helper::results(1,'删除失败',$data['data'], 'post');
        }
    }

    
}
