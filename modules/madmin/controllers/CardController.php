<?php

namespace app\modules\madmin\controllers;


use app\models\Helper;
use yii;
use app\controllers\AdminController;
use Da\QrCode\QrCode;
use app\models\Certificate;
/**
 * 证书控制器
 */
class CardController extends AdminController
{
    
    /**
     *列表
     * @return string
     */
    public function actionIndex()
    {

        $list = Certificate::find()->select(['certificateId','name','sex','card','num','pic','createTime'])->all();
        return $this->render('index',['list'=>$list]);
    }




    public function actionAdd(){
        $model = new Certificate();
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Certificate');
            $model->attributes = $data;
                $re = $model->add($data);
                if($re['state']){
                    //var_dump($re['data']);
                    $this->Qrcode($re['data']['certificateId']);
                    return $this->redirect('index');
                    exit;
                }else{
                    $errmsg = Helper::modelerror($re['data']);
                }

        }
        $model['type'] = '防水工';
        $model['level'] = '中级工';
        $model['organization'] = '尉氏县众创职业培训学校';
        $model['createTime'] = date('Y 年 m 月 d 日',time());
        return $this->render('create',['model'=>$model,'errmsg'=>$errmsg]);
    }

    public function actionEdit($id){
        $model = Certificate::findOne($id);
        $errmsg ='';
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Certificate');
            $model->attributes = $data;
            $re = $model->up($id,$data);
            if($re['state']){
                $this->Qrcode($id);
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
        $model = new Certificate();
        $data = $model->up($id,['state'=>0]);
        if($data['state']){
            Helper::results(0,'删除成功',$data['data'], 'post');
        }else{
            Helper::results(1,'删除失败',$data['data'], 'post');
        }
    }
    /**
     * 合并图片
     * @param $id
     * @return bool
     */
    public function Qrcode($id)
    {
        $model = Certificate::findOne($id);
        if($model){
            $url = 'http://www.hndzzz.com/card/detail?id='.$id;
            $qrCode = (new QrCode($url))
                ->setSize(424)
                ->setMargin(10)
                ->useForegroundColor(000, 000, 000);
            $Directroy = Yii::$app->params['uploadPath'];
            //创建文件存放路径
            $Directroy = $Directroy."/";
            $pathd = $Directroy.'card/';
            //dump(Yii::$app->BasePath.'/web/'.$pathd);
            $dir =Yii::$app->BasePath.'/web/'.$pathd;
            Helper::Makedir($dir); //创建文件夹
            $qr = $dir. '/code_'.$id.'.png';
            $qrCode->writeFile($qr); // writer defaults to PNG when none is specified
            $background = Yii::$app->BasePath.'/web/hndzzz/demo.png';
            $new = $this->save($dir,$qr,$background,$id);//合并二维码图片
            $newpic = $dir.'card_'.$id.'.png';
            //更新头像
            if(!empty($model['face'])){
                $new = $this->save($dir,Yii::$app->BasePath.'/web/'.$model['face'],$newpic,$id,1456,829);//合并头像图片
            }
            $this->wtext($newpic,$model['type'],874,625);//向图片写入工种
            $this->wtext($newpic,$model['level'],1321,625);//向图片写入等级
            //$this->wtext($newpic,$model['sex'],580,1005);//向图片写入性别
            $this->wtext($newpic,$model['name'],580,878);//向图片写入姓名
            $this->wtext($newpic,$model['card'],580,1130,2);//向图片写入身份证号
            $this->wtext($newpic,$model['num'],580,1253,2);//向图片写入证件编号
            $this->wtext($newpic,$model['createTime'],483,2397);//向图片写入证件编号
            $zhang = Yii::$app->BasePath.'/web/hndzzz/zhang.png';
            $this->zhang($zhang,$newpic,600,2109);//合并公章图片
            //dump($new);
            $model->up($id,['qrcode'=>$pathd.'code_'.$id.'.png','pic'=>$pathd.$new]);//更新图片地址
        }
        return true;
    }

    /**
     * 生成二维码
     * @param $path 生成地址
     * @param $file_path 二维码图片地址
     * @param $background 背景图地址
     * @param $x x坐标
     * @param $y y坐标
     * @return string
     */
    public function save($path,$file_path,$background,$id=null,$x=1304,$y=1794)
    {
        if($id){
            $fileName = 'card_'.$id.'.png';
        }else{
            $fileName = rand(100,999).time().'.png';
        }

        /*$path ='./public/wechat_img/'; //存放海报 / icon图片文件夹
        $QR   = $file_path;  //二维码略缩图
        $logo = $path.'icon.png';  //小icon 原图
        $QR = imagecreatefromstring(file_get_contents($QR));
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR);//二维码图片宽度
        $QR_height = imagesy($QR);//二维码图片高度
        $logo_width = imagesx($logo);//logo图片宽度
        $logo_height = imagesy($logo);//logo图片高度
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);

        $QIMG = $path . rand(1000,9999) .time(). ".png";
        imagepng($QR, $QIMG);*/

        $dst_path = $background;//背景图片路径
        $src_path = $file_path;//覆盖图
        //创建图片的实例

        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));

        //获取覆盖图图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
        if($id == null){
            //dump($src_w);
        }
        //创建一个和人物图片一样大小的真彩色画布（ps：只有这样才能保证后面copy装备图片的时候不会失真）
        /*$image_3 = imageCreatetruecolor(imagesx($dst),imagesy($src));
        //为真彩色画布创建白色背景，再设置为透明
        $color = imagecolorallocate($image_3, 255, 255, 255);
        imagefill($image_3, 0, 0, $color);
        imageColorTransparent($image_3, $color);
        //首先将人物画布采样copy到真彩色画布中，不会失真
        imagecopyresampled($image_3,$dst,0,0,0,0,imagesx($dst),imagesy($dst),imagesx($dst),imagesy($dst));
        //再将装备图片copy到已经具有人物图像的真彩色画布中，同样也不会失真
        imagecopymerge($image_3,$src, $x,$y,0,0,$src_w,$src_h, 100);*/

        //将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        imagecopymerge($dst, $src, $x, $y, 0, 0, $src_w, $src_h, 100);

        //@unlink($QIMG); //删除二维码与logo的合成图片
        //header("Content-type: image/jpg");
        imagepng($dst, $path . $fileName );//根据需要生成相应的图片
        imagedestroy($dst);
        imagedestroy($src);
        //imagedestroy($image_3);
        return $fileName;
    }

    protected function wtext($filename,$string,$x,$y,$font=1){
        //获取图片的属性，第一个宽度，第二个高度，类型1=>gif，2=>jpeg,3=>png
        list($width,$height,$type) = getimagesize($filename);
        //可以处理的图片类型
        $types = array(1=>"gif",2=>"jpeg",3=>"png",);
        //通过图片类型去组合，可以创建对应图片格式的，创建图片资源的GD库函数
        $createfrom = "imagecreatefrom".$types[$type];
        //通过“变量函数”去打对应的函数去创建图片的资源
        $image = $createfrom($filename);
        //设置居中字体的X轴坐标位置
        //$x = ($width-imagefontwidth(5)*strlen($string))/2;
        //设置居中字体的Y轴坐标位置
        //$y = ($height-imagefontheight(5))/1.18;
        //设置字体的颜色为红色
        $textcolor = imagecolorallocate($image, 0, 0, 0);
        //向图片画一个指定的字符串
//        imagestring($image, 5, $x, $y, $string, $textcolor);
        switch ($font){
            case 1:
                $font = Yii::$app->BasePath.'/web/font/adobeheitistd-regular.otf'; //黑体字
                break;
            case 2:
                $font = Yii::$app->BasePath.'/web/font/arial.ttf'; //arial字体在服务器上的绝对路径
                break;
            case 3:
                $font = Yii::$app->BasePath.'/web/font/arial.ttf'; //arial字体在服务器上的绝对路径
                break;
        }



        imagefttext($image, 38, 0, $x, $y, $textcolor, $font, $string);
        //通过图片类型去组合保存对应格式的图片函数
        $output = "image".$types[$type];
        //通过变量函数去保存对应格式的图片
        $output($image,$filename);
        imagedestroy($image);
        return true;
    }

    protected function zhang($file_path,$background,$x=1304,$y=1794){

        //创建源图的实例
        $src = imagecreatefromstring(file_get_contents($background));
        //创建点的实例
        $des = imagecreatefrompng($file_path);
        //获取点图片的宽高
        list($point_w, $point_h) = getimagesize($file_path);

        //重点：png透明用这个函数
        imagecopy($src, $des, $x, $y, 0, 0, $point_w, $point_h);

        header('Content-Type: image/png');
        imagepng($src,$background);
        imagedestroy($src);
        imagedestroy($des);
        return true;

    }



    
}
