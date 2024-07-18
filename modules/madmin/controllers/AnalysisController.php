<?php

namespace app\modules\madmin\controllers;


use app\models\AnalysisKeyword;
use app\models\AnalysisAsins;
use app\models\AnalysisAsinsLog;
use app\models\Helper;
use yii;
use app\controllers\AdminController;
/**
 * 控制器
 */
class AnalysisController extends AdminController
{
    
    /**
     *列表
     * @return string
     */
    public function actionIndex()
    {
        $memberId = Yii::$app->request->get('memberId',0);
        if($memberId>0){
            $list = AnalysisAsins::find()->where(['memberId'=>$memberId])->all();
        }else{
            $list = AnalysisAsins::find()->select(['asinid','memberId','asins','region','inputtime'])->all();
        }
        //dump($list);
        return $this->render('index',['list'=>$list,'memberId'=>$memberId]);
    }

    public function actionAjaxlist()
    {
        $draw = Yii::$app->request->get('draw');
        $memberId = Yii::$app->request->get('memberId');
        $getdata = Yii::$app->request->get();

        $iDisplayLength = Yii::$app->request->get('length', 100);
        $iDisplayStart = Yii::$app->request->get('start', 0);
        //搜索框
        $search = trim($getdata['search']['value']);    //获取前台传过来的过滤条件
        $where = ['state'=>1];
        if($memberId>0) {
            $where['memberId'] = $memberId;
        }else{

        }
        if(isset($search)){
            $where = ['or',['like', 'asins', $search],['like', 'md5', $search]];
        }

        $Array = AnalysisAsins::find()->where($where)->select(['asinid','memberId','asins','region','inputtime'])->asArray()->all();
        //dump($Array);
        $count= count($Array);
        $json_data = array ('draw'=>intval($draw),'recordsTotal'=>intval($count),'recordsFiltered'=>intval($count),'data'=>array_slice($Array,$iDisplayStart,$iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data);
        echo $obj;
        exit;
    }






    public function actionEdit($id){
        $model = Cmsnews::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('');
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
        $model = new AnalysisAsins();
        $data = $model->up($id,['state'=>0]);
        if($data['state']){
            $this->redirect('index');
        }else{
            $this->redirect('index');
        }
    }


    
}
