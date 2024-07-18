<?php

namespace app\modules\madmin\controllers;

use app\models\Helper;
use app\models\Sysmenu;
use yii;
use app\controllers\AdminController;
use app\models\LoginForm;

/**
 * Default controller for the `manage` module
 */
class MenuController extends AdminController
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
        $model = new Sysmenu();
        $fatherId= Yii::$app->request->get('fatherId','000000000000');
        $allmenu = $model->getMenuOption();
        if (Yii::$app->request->isPost) {
            $settingdata = Yii::$app->request->post('Sysmenu');
            $sysmenuId = $model->getMenuId($fatherId);
            $settingdata['sysmenuId'] = $sysmenuId;
            //dump($settingdata);
            $re = $model->add($settingdata,$fatherId);
            if($re['state']){
                $this->redirect('index');
            }else{
                return $this->render('create',['model'=>$model,'allmenu'=>$allmenu,'error'=>$re['data']]);
            }
        }
        return $this->render('create',['model'=>$model,'allmenu'=>$allmenu,'fatherId'=>$fatherId]);
    }

    /**
     * 编辑菜单
     * @param $id
     * @return string
     */
    public function actionEdit($id){
        $model = Sysmenu::findOne(['sysmenuId'=>$id]);
        $sysmenu = new Sysmenu();
        $allmenu = $sysmenu->getMenuOption();
        if (Yii::$app->request->isPost) {
            $settingdata = Yii::$app->request->post('Sysmenu');
            //dump($settingdata);
            $re = $sysmenu->up($id,$settingdata);
            if($re['state']){
                $this->redirect('index');
            }else{
                return $this->render('edit',['model'=>$model,'allmenu'=>$allmenu,'error'=>$re['data']]);
            }

        }
        return $this->render('edit',['model'=>$model,'allmenu'=>$allmenu]);
    }


    /**
     * AJAX更新菜单
     */
    public function actionUpdate(){
        $type = Yii::$app->request->get('type');
        $id = Yii::$app->request->get('id');
        $content = Yii::$app->request->get('content');
        $data ='';
        $model = new Sysmenu();
        switch ($type){
            case 'title':
                $data = $model->up($id,['title'=>$content]);
                break;
            case 'route':
                $data = $model->up($id,['route'=>$content]);
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
        $model = new Sysmenu();
        $data = $model->del($id);
        if($data['state']){
            Helper::results(0,'删除成功',$data['data'], 'post');
        }else{
            Helper::results(1,'删除失败',$data['data'], 'post');
        }
    }

    public function actionCachedel(){
        Yii::$app->cache->delete('sysmenu');//缓存
        $this->redirect('index');
    }

    
}
