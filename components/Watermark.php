<?php
namespace app\components;

use Yii;

class Watermark
{
    //生成路径
   public $path;
   //水印文字
   public $watermark_string;

    /**
     * 合并图片，
     * @param $watermark_path
     * @param $background_path
     * @param null $id
     * @param int $x
     * @param int $y
     * @param string $type
     * @param string $pct
     * @return string
     */
    public function wImage($watermark_path,$background_path,$id=null,$x=1304,$y=1794,$type='png',$pct=100)
    {
        if($id){
            $fileName = 'card_'.$id.'.'.$type;
        }else{
            $fileName = rand(100,999).time().'.'.$type;
        }
        //创建图片的实例

        $dst = imagecreatefromstring(file_get_contents($background_path));//背景图片
        $src = imagecreatefromstring(file_get_contents($watermark_path));//覆盖图

        //获取覆盖图图片的宽高
        list($src_w, $src_h) = getimagesize($watermark_path);

        //将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        imagecopymerge($dst, $src, $x, $y, 0, 0, $src_w, $src_h, $pct);

        //header("Content-type: image/jpg");
        switch ($type){
            case 'png':
                imagepng($dst, $this->path . $fileName );//根据需要生成相应的图片
            case 'jpg':
                imagejpeg($dst, $this->path . $fileName );//根据需要生成相应的图片
        }
        imagedestroy($dst);
        imagedestroy($src);
        return $fileName;//输出图片
    }

    /**
     * 在图片上写入文字
     * @param $background_path 背景图
     * @param $string 写入的文字
     * @param $x x坐标
     * @param $y Y坐标
     * @param int $font 字体类型
     * @return bool
     */
    public function wText($background_path,$string,$x,$y,$font=1){
        //获取图片的属性，第一个宽度，第二个高度，类型1=>gif，2=>jpeg,3=>png
        list($width,$height,$type) = getimagesize($background_path);
        //可以处理的图片类型
        $types = array(1=>"gif",2=>"jpeg",3=>"png",);
        //通过图片类型去组合，可以创建对应图片格式的，创建图片资源的GD库函数
        $createfrom = "imagecreatefrom".$types[$type];
        //通过“变量函数”去打对应的函数去创建图片的资源
        $image = $createfrom($background_path);
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
                $font = Yii::$app->BasePath.'/font/adobeheitistd-regular.otf'; //黑体字
                break;
            case 2:
                $font = Yii::$app->BasePath.'/font/arial.ttf'; //arial字体在服务器上的绝对路径
                break;
            case 3:
                $font = Yii::$app->BasePath.'/font/arial.ttf'; //arial字体在服务器上的绝对路径
                break;
        }

        imagefttext($image, 38, 0, $x, $y, $textcolor, $font, $string);
        //通过图片类型去组合保存对应格式的图片函数
        $output = "image".$types[$type];
        //通过变量函数去保存对应格式的图片
        $output($image,$background_path);
        imagedestroy($image);
        return true;
    }

    /**
     * 透明PNG图合并
     * @param $watermark_path  透明的PNG图
     * @param $background_path 底图
     * @param int $x x坐标
     * @param int $y Y坐标
     * @return bool
     */
    public function toPng($watermark_path,$background_path,$x=1304,$y=1794){

        //创建源图的实例
        $src = imagecreatefromstring(file_get_contents($background_path));
        //创建点的实例
        $des = imagecreatefrompng($watermark_path);
        //获取点图片的宽高
        list($point_w, $point_h) = getimagesize($watermark_path);

        //重点：png透明用这个函数
        imagecopy($src, $des, $x, $y, 0, 0, $point_w, $point_h);

        header('Content-Type: image/png');
        imagepng($src,$background_path);
        imagedestroy($src);
        imagedestroy($des);
        return true;
    }




}