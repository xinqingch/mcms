<?php
namespace app\components\images;

use Yii;
use app\models\Attachment;
use app\models\Helper;
use yii\web\UploadedFile;
class ImageFile extends AttachmentFile
{

    public function save($fileName=null, $attributes=[])
    {
        $data =[];
        $size = json_decode( $this->thumbSize );//读取缩略图规格
        if( $fileName != null ) {
            $model = new Attachment();
            //保存图片

            $Directroy = Yii::$app->params['uploadPath'];
            //创建文件存放路径
            $y         = date('Y');
            $m         = date('m');
            $d         = date('d');
            $Directroy = $Directroy."/";
            $pathd = $Directroy.$y."/".$m."/".$d."/";
            //dump(Yii::$app->BasePath.'/web/'.$pathd);
            Helper::Makedir(Yii::$app->BasePath.'/web/'.$pathd); //创建文件夹
            $filename               = time().rand(11111,99999);
            $ext                    = $attributes['ext'];//上传文件的扩展名
            $fileurl = $pathd.$filename.'.'.$ext;
            //检测Md5
            $check = $model->check($attributes['md5key']);
            //dump($check);
            if( $check ){//如果图片不存在
                //dump(1);
                $fileName->saveAs($fileurl);
                //dump($fileName);exit;
                $attributes['url'] = $fileurl;
                $attributes['state'] = 1;
                $attributes['inputtime'] =time();
                foreach ($size as $v){
                    $thumburl = $pathd.$filename.'_'.$v.'.'.$ext;
                    //生成缩略图
                    $thumb = $this->thumb( $fileurl , $v , $v );
                    file_put_contents($thumburl, $thumb);
                    //$fileName->saveAs($thumburl);
                    if($v==100){
                        $attributes['thumb'] = $thumburl;
                    }
                }
                //dump($attributes);exit;
                $data = $model->add($attributes);
                //dump($data);
            }else{
                //dump($attributes);
                $data['state']=true;
                $data['data'] = $model->getfile($attributes['md5key']);
                //dump($data);
            }

        }
        return $data;
    }


    /**
     * 下载远程文件
     * @param $str
     */
    public function downRemote( $str ){

    }
}