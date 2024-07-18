<?php

namespace app\modules\madmin\controllers;

use app\models\Cmspage;
use app\models\Helper;
use app\models\Nav;
use yii;
use app\controllers\AdminController;

/**
 * 栏目
 */
class CategoryController extends AdminController
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
        $model = new nav();
        $fatherId= Yii::$app->request->get('parentid',0);
        $PageType = $model->getPageType();
        if (Yii::$app->request->isPost) {
            $settingdata = Yii::$app->request->post('Nav');

            $re = $model->add($settingdata);
            if($re['state']){
                $this->redirect('index');
            }else{
                return $this->render('create',['model'=>$model,'PageType'=>$PageType,'error'=>Helper::modelerror($re['data'])]);
            }
        }
        return $this->render('create',['model'=>$model,'PageType'=>$PageType,'fatherId'=>$fatherId]);
    }

    /**
     * 编辑菜单
     * @param $id
     * @return string
     */
    public function actionEdit($id){
        $model = Nav::findOne($id);
        $PageType = $model->getPageType();
        if (Yii::$app->request->isPost) {
            $settingdata = Yii::$app->request->post('Nav');
            //dump($settingdata);
            $re = $model->up($id,$settingdata);
            if($re['state']){
                $this->redirect('index');
            }else{
                return $this->render('edit',['model'=>$model,'PageType'=>$PageType,'error'=>Helper::modelerror($re['data'])]);
            }

        }
        return $this->render('edit',['model'=>$model,'PageType'=>$PageType,'fatherId'=>$fatherId]);
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
            case 'title_en':
                $data = $model->up($id,['title_en'=>$content]);
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

    /**
     * 单页处理
     */
    public function actionCmspage(){
        $id = Yii::$app->request->get('id');
        $check = Cmspage::checkField('navId',$id);

        if($check==false){
            $model = new Cmspage();
            $model->navId = $id;
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post('Cmspage');
                $re = $model->add($data);
                if($re['state']){
                    $this->redirect('index');
                }else{
                    return $this->render('edit',['model'=>$model,'error'=>Helper::modelerror($re['data'])]);
                }

            }
        }else{
            $model = Cmspage::find()->where(['navId'=>$id])->one();
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post('Cmspage');
                $re = $model->up($model['pageId'],$data);
                if($re['state']){
                    $this->redirect('index');
                }else{
                    return $this->render('edit',['model'=>$model,'error'=>Helper::modelerror($re['data'])]);
                }

            }
        }
        //dump($model);
        return $this->render('editpage',['model'=>$model]);
    }

    
}
