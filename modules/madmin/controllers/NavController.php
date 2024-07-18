<?php

namespace app\modules\madmin\controllers;

use app\models\Helper;
use app\models\Nav;
use app\models\Sysmenu;
use yii;
use app\controllers\AdminController;
use app\models\LoginForm;

/**
 * Default controller for the `manage` module
 */
class NavController extends AdminController
{
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * 添加菜单
     */
    public function actionAdd(){
        $model = new Nav();
        $parentid= Yii::$app->request->get('parentid','0');
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Nav');
            $re = $model->add($data);
            if($re['state']){
                $this->redirect('index');
            }else{
                //dump($re['data']);
                return $this->render('create',['model'=>$model,'error'=>Helper::modelerror($re['data'])]);
            }
        }
        return $this->render('create',['model'=>$model,'parentid'=>$parentid]);
    }

    /**
     * 编辑菜单
     * @param $id
     * @return string
     */
    public function actionEdit($id){
        $model = Nav::findOne(['navId'=>$id]);
        $sysmenu = new Nav();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Nav');
            //dump($settingdata);
            $re = $sysmenu->up($id,$data);
            if($re['state']){
                $this->redirect('index');
            }else{
                return $this->render('edit',['model'=>$model,'error'=>$re['data']]);
            }

        }
        return $this->render('edit',['model'=>$model]);
    }


    /**
     * AJAX更新菜单
     */
    public function actionUpdate(){
        $type = Yii::$app->request->get('type');
        $id = Yii::$app->request->get('id');
        $content = Yii::$app->request->get('content');
        $data ='';
        $model = new Nav();
        switch ($type){
            case 'title':
                $data = $model->up($id,['title'=>$content]);
                break;
            case 'url':
                $data = $model->up($id,['url'=>$content]);
                break;
            case 'listorder':
                $data = $model->up($id,['listorder'=>(int)$content]);
                break;
        }
        if($data['state']){
            Helper::results(0,'更新成功',$data['data'], 'post');
        }else{
            Helper::results(1,'更新失败',$data['data'], 'post');
        }

    }

    /**
     * 删除菜单
     */
    public function actionDelete($id){
        $model = new Nav();
        $data = $model->del($id);
        if($data['state']){
            Helper::results(0,'删除成功',$data['data'], 'post');
        }else{
            Helper::results(1,'删除失败',$data['data'], 'post');
        }
    }

    
}
