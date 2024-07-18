<?php

namespace app\modules\madmin\controllers;


use app\models\Cmsnews;
use app\models\Helper;
use yii;
use app\controllers\AdminController;
/**
 * 资讯控制器
 */
class NewsController extends AdminController
{
    
    /**
     *列表
     * @return string
     */
    public function actionIndex()
    {
        $navId = Yii::$app->request->get('navId',0);
        if($navId>0){
            $list = Cmsnews::find()->where(['navId'=>$navId,'state'=>1])->select(['newsId','navId','title','hits','source','state','inputtime'])->all();
        }else{
            $list = Cmsnews::find()->select(['newsId','navId','title','hits','source','state','inputtime'])->all();
        }
        return $this->render('index',['list'=>$list,'navId'=>$navId]);
    }

    public function actionAjaxlist()
    {
        $draw = Yii::$app->request->get('draw');
        $navId = Yii::$app->request->get('navId');
        $getdata = Yii::$app->request->get();

        $iDisplayLength = Yii::$app->request->get('length', 100);
        $iDisplayStart = Yii::$app->request->get('start', 0);
        //搜索框
        $search = trim($getdata['search']['value']);    //获取前台传过来的过滤条件
        $where = ['state'=>1];
        if($navId>0) {
            $where['navId'] = $navId;
        }else{

        }
        if(isset($search)){
            $where = ['or',['like', 'title', $search],['like', 'title_en', $search],['like', 'source', $search]];
        }

        $Array = Cmsnews::find()->where($where)->select(['newsId', 'navId', 'title', 'hits', 'source', 'state', 'inputtime'])->asArray()->all();
        $count= count($Array);
        $json_data = array ('draw'=>intval($draw),'recordsTotal'=>intval($count),'recordsFiltered'=>intval($count),'data'=>array_slice($Array,$iDisplayStart,$iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data);
        echo $obj;
        exit;
    }




    public function actionAdd(){
        $navId = Yii::$app->request->get('navId');
        $model = new Cmsnews();
        $model->navId = $navId;
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Cmsnews');
            $model->attributes = $data;
                $re = $model->add($data);
                if($re['state']){
                    return $this->redirect('index');
                    exit;
                }else{
                    $errmsg = Helper::modelerror($re['data']);
                }

        }
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg]);
    }

    public function actionEdit($id){
        $model = Cmsnews::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Cmsnews');
            $model->attributes = $data;
            $re = $model->up($id,$data);
            if($re['state']){
                return $this->redirect('index');
                exit;
            }else{
                $errmsg = Helper::modelerror($re['data']);
            }



        }
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg]);
    }

    /**
     * 删除管理员
     */
    public function actionDelete($id){
        $model = new Cmsnews();
        $data = $model->up($id,['state'=>0]);
        if($data['state']){
            $this->redirect('index');
        }else{
            $this->redirect('index');
        }
    }


    
}
