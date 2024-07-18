<?php

namespace app\modules\madmin\controllers;


use app\models\Helper;
use app\models\Apiuser;
use yii;
use app\controllers\AdminController;
use app\models\Adminer;
use app\components\message\MessageStorage;


/**
 * 用户控制器
 */
class ApiuserController extends AdminController
{
    
    /**
     *用户列表
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate(){
        $model = new Apiuser();
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Apiuser');
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
    public function actionAjaxlist()
    {
        $draw = Yii::$app->request->get('draw');
        $getdata = Yii::$app->request->get();

        $iDisplayLength = Yii::$app->request->get('length', 100);
        $iDisplayStart = Yii::$app->request->get('start', 0);
        //搜索框
        $search = trim($getdata['search']['value']);    //获取前台传过来的过滤条件
        $where = ['1'=>1];

        if(isset($search)){
            $where = ['like', 'username', $search];
        }

        $Array = Apiuser::find()->where($where)->select(['id', 'username', 'type'])->asArray()->orderBy('id DESC')->all();


        $count= count($Array);
        $json_data = array ('draw'=>intval($draw),'recordsTotal'=>intval($count),'recordsFiltered'=>intval($count),'data'=>array_slice($Array,$iDisplayStart,$iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
        $obj=json_encode($json_data);
        echo $obj;
        exit;
    }

    public function actionEdit($id){
        $model = Apiuser::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Apiuser');
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
        $model = Apiuser::findOne($id);
        $data = $model->delete();
        if($data){
            Helper::results(0,'删除成功',$model->attributes(), 'post');
        }else{
            Helper::results(1,'删除失败',$model->attributes(), 'post');
        }
    }



    
}
