<?php
namespace app\components\images;

use Yii;
use yii\web\HttpException;
use app\models\Helper;
use yii\web\UploadedFile;
use app\models\Attachment;

class OfficeFile extends AttachmentFile
{
    public function save($fileName=null, $attributes=[])
    {
        $data =[];
        if( $fileName != null ) {
            $model = new Attachment();
            //保存图片

            $Directroy = Yii::$app->params['uploadPath'];
            //创建文件存放路径
            $y         = date('Y');
            $m         = date('m');
            $d         = date('d');
            $Directroy = $Directroy."/file/";
            $pathd = $Directroy.$y."/".$m."/".$d."/";
            //dump(Yii::$app->BasePath.'/web/'.$pathd);
            Helper::Makedir(Yii::$app->BasePath.'/web/'.$pathd); //创建文件夹
            $filename               = time().rand(11111,99999);
            $ext                    = $attributes['ext'];//上传文件的扩展名
            $fileurl = $pathd.$filename.'.'.$ext;
            //检测Md5
            $check = $model->check($attributes['md5key']);
            //dump($check);
            if( $check ){//如果不存在
                $fileName->saveAs($fileurl);
                $attributes['url'] = $fileurl;
                $attributes['state'] = 1;
                $attributes['inputtime'] =time();
                $data = $model->add($attributes);
            }else{
                $data['state']=true;
                $data['data'] = $model->getfile($attributes['md5key']);
            }

        }
        return $data;
    }
}