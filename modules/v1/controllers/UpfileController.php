<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\Helper;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\components\images\ImagesStorage;
/**
 * Default controller for the `v1` module
 */
class UpfileController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 创建方法
     */
    public function actionCreate() {
        //dump($_POST);exit;
        if (Yii::$app->request->isPost) {
            $File = UploadedFile::getInstanceByName('upFile');
            //dump($File);exit;
            if ($File) {
                $model = new ImagesStorage();
                $extname = preg_replace('/^.*\./','',$File->name);
                $ext = $model->getFileExt($File->tempName);//取文件扩展名
                if($extname!=$ext){
                    $ext =$extname;
                }
                $attributes=[
                    'file_name'=>$File->name,
                    'file_type'=>$File->type,
                    'file_size'=>$File->size,
                    'title'=>Helper::str_cut($File->name,30),
                    'is_image'=>$model->checkISimage($ext),
                    'ip'=>ip2long(Helper::GetIP()),
                    'md5key'=>md5_file($File->tempName),
                    'ext'=>$ext,
                ];
                //dump($File);exit;
                $data = $model->save($File,$attributes,$ext);
                // 文件上传成功
                //return;
                if($data['state']){
                    Helper::results(0,'',$data['data'], 'post');
                }else{
                    Helper::results(102,$data['data'],null, 'post');
                }
            }
            Helper::results(101,'请选择您要上传的文件',null, 'post');
        }
        Helper::results(0,'',Yii::$app->request->post(), 'post');
    }

    /**
     * 更新方法
     */
    public function actionUpdate() {
        Helper::results(0,'',Yii::$app->request->post(), 'put');
    }

    /**
     * 删除方法
     */
    public function actionDelete() {
        Helper::results(0,'',Yii::$app->request->get(), 'delete');
    }

    /**
     * 查看方法
     */
    public function actionView() {
        Helper::results(0,'',Yii::$app->request->get(), 'view');
    }
}
