<?php
namespace app\components\images;

use Yii;
use yii\web\HttpException;
use app\models\Attachment;
use app\models\Helper;

abstract class AttachmentFile {

    public $thumbSize = '{"sm":"50","s":"80","df":"100","lg":"160","xl":"200","xxl":"300","big":"600"}';
    /**
     * 输出文件
     * @param string $id UID
     * @param array $attributes 查询条件
     */
    public function find($id ,$attributes=array()){
        $model = new Attachment();
        if(empty($attributes)){
            $model->getIdfile($id);
        }else{
            $model = Attachment::find()->where($attributes)->one();
        }

        return $model;
    }
    /**
     * 保存文件
     * @param string $fileName　文件名
     * @param array $attributes 其它参数
     * @return boolean|unknown
     */
    public function save($fileName, $attributes ){
        $model = new Attachment();
        $attributes['md5key'] = md5_file($fileName);
        $data = $model->add($attributes);
        return $data;
    }
    /**
     * 更新数据
     * @param string $id UID
     * @param array $set 更新数据
     * @param array $attributes 条件
     */
    public function update($id,$set,$attributes=array()){

    }
    /**
     * 删除方法
     * @param string $id
     * @param array $attributes
     * @return unknown
     */
    public function deleteAll($id, $attributes=null){

    }

    /**
     * 下载远程文件
     * @param $str
     */
    public function downRemote( $str ){

    }


    /**
     * 生成固定大小的图像并按比例缩放
     * @param string  $im 图像元数据
     * @param int $w 最大宽度
     * @param int $h 最大高度
     */
    public  function thumb($im,$w,$h){
        if(empty($im) || empty($w) || empty($h) || !is_numeric($w) || !is_numeric($h)){
            throw new Exception("缺少必须的参数");
        }
        $im = $this->IM($im); //创建图像
        list($im_w,$im_h) = self::getsize($im); //获取图像宽高
        if($im_w > $im_h || $w < $h){
            $new_h = intval(($w / $im_w) * $im_h);
            $new_w = $w;
        }else{
            $new_h = $h;
            $new_w = intval(($h / $im_h) * $im_w);
        }
        //echo "$im_w x $im_h <br/> $new_w x $new_h <br/> $x $y";exit;
        //开始创建缩放后的图像
        $dst_im = imagecreatetruecolor($new_w,$new_h);
        imagecopyresampled($dst_im,$im,0,0,0,0,$new_w,$new_h,$im_w,$im_h);

        //添加白边
        $final_image = imagecreatetruecolor($w, $h);
        $color = imagecolorallocate($final_image, 255, 255, 255);
        imagefill($final_image, 0, 0, $color);
        $x = round(($w - $new_w) / 2);
        $y = round(($h - $new_h) / 2);
        imagecopy($final_image, $dst_im, $x, $y, 0, 0, $new_w, $new_h);

        ob_start();
        imagejpeg($final_image);
        $bite = ob_get_contents();
        ob_end_clean();
        return $bite;
    }


    /**
     * 通过文件，获取不同的GD对象
     */
    protected function IM($file)
    {
        if(!file_exists($file)) die('File not exists.');
        $info = getimagesize($file);
        switch($info['mime'])
        {
            case 'image/gif':
                $mim = imagecreatefromgif($file);
                break;

            case 'image/png':
                $mim = imagecreatefrompng($file);
                imagealphablending($mim, false);
                imagesavealpha($mim, true);
                break;

            case 'image/jpeg':
                $mim = imagecreatefromjpeg($file);
                break;
            case 'image/x-ms-bmp':
                $mim = $this->ImageCreateFromBMP($file);
                break;
            default:
                die('File format errors.');
        }
        return $mim;
    }

    /**
     * 创建Bmp图像
     * @param unknown_type $filename
     * @return boolean|resource
     */
    protected function ImageCreateFromBMP($filename) {
        //Ouverture du fichier en mode binaire
        if (!$f1 = fopen($filename, "rb"))
            return FALSE;

        //1 : Chargement des ent�tes FICHIER
        $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));
        if ($FILE['file_type'] != 19778)
            return FALSE;

        //2 : Chargement des ent�tes BMP
        $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' .
            '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
            '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));
        $BMP['colors'] = pow(2, $BMP['bits_per_pixel']);
        if ($BMP['size_bitmap'] == 0)
            $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
        $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel'] / 8;
        $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
        $BMP['decal'] = ($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
        $BMP['decal'] -= floor($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
        $BMP['decal'] = 4 - (4 * $BMP['decal']);
        if ($BMP['decal'] == 4)
            $BMP['decal'] = 0;

        //3 : Chargement des couleurs de la palette
        $PALETTE = array();
        if ($BMP['colors'] < 16777216) {
            $PALETTE = unpack('V' . $BMP['colors'], fread($f1, $BMP['colors'] * 4));
        }

        //4 : Cr�ation de l'image
        $IMG = fread($f1, $BMP['size_bitmap']);
        $VIDE = chr(0);

        $res = imagecreatetruecolor($BMP['width'], $BMP['height']);
        $P = 0;
        $Y = $BMP['height'] - 1;
        while ($Y >= 0) {
            $X = 0;
            while ($X < $BMP['width']) {
                if ($BMP['bits_per_pixel'] == 24)
                    $COLOR = unpack("V", substr($IMG, $P, 3) . $VIDE);
                elseif ($BMP['bits_per_pixel'] == 16) {
                    $COLOR = unpack("n", substr($IMG, $P, 2));
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                } elseif ($BMP['bits_per_pixel'] == 8) {
                    $COLOR = unpack("n", $VIDE . substr($IMG, $P, 1));
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                } elseif ($BMP['bits_per_pixel'] == 4) {
                    $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));
                    if (($P * 2) % 2 == 0)
                        $COLOR[1] = ($COLOR[1] >> 4);
                    else
                        $COLOR[1] = ($COLOR[1] & 0x0F);
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                }
                elseif ($BMP['bits_per_pixel'] == 1) {
                    $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));
                    if (($P * 8) % 8 == 0)
                        $COLOR[1] = $COLOR[1] >> 7;
                    elseif (($P * 8) % 8 == 1)
                        $COLOR[1] = ($COLOR[1] & 0x40) >> 6;
                    elseif (($P * 8) % 8 == 2)
                        $COLOR[1] = ($COLOR[1] & 0x20) >> 5;
                    elseif (($P * 8) % 8 == 3)
                        $COLOR[1] = ($COLOR[1] & 0x10) >> 4;
                    elseif (($P * 8) % 8 == 4)
                        $COLOR[1] = ($COLOR[1] & 0x8) >> 3;
                    elseif (($P * 8) % 8 == 5)
                        $COLOR[1] = ($COLOR[1] & 0x4) >> 2;
                    elseif (($P * 8) % 8 == 6)
                        $COLOR[1] = ($COLOR[1] & 0x2) >> 1;
                    elseif (($P * 8) % 8 == 7)
                        $COLOR[1] = ($COLOR[1] & 0x1);
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                } else
                    return FALSE;
                imagesetpixel($res, $X, $Y, $COLOR[1]);
                $X++;
                $P += $BMP['bytes_per_pixel'];
            }
            $Y--;
            $P+=$BMP['decal'];
        }

        //Fermeture du fichier
        fclose($f1);

        return $res;
    }

    /**
     * 获取图像大小
     * @param string  $im 图像元数据
     * @return array
     */
    protected static function getsize( $im ){
        return array(imagesx($im),imagesy($im));
    }


    /**
     * 取字符串内容的所有图片
     * @param $str
     */
    public function getWordimg($str){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$str,$match);
        return $match[1];
    }


    /**
     * 下载远程图片
     * @param string $url 图片的绝对url
     * @param string $filepath 文件的完整路径（包括目录，不包括后缀名,例如/www/images/test） ，此函数会自动根据图片url和http头信息确定图片的后缀名
     * @return mixed 下载成功返回一个描述图片信息的数组，下载失败则返回false
     */
    public function downloadImage($url, $filepath) {
        //服务器返回的头信息
        $responseHeaders = array();
        //原始图片名
        $originalfilename = '';
        //图片的后缀名
        $ext = '';
        $ch = curl_init($url);
        //设置curl_exec返回的值包含Http头
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置curl_exec返回的值包含Http内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置抓取跳转（http 301，302）后的页面
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //设置最多的HTTP重定向的数量
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);

        //服务器返回的数据（包括http头信息和内容）
        $html = curl_exec($ch);
        //dump($html);exit;
        //获取此次抓取的相关信息
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        if ($html !== false) {
            //分离response的header和body，由于服务器可能使用了302跳转，所以此处需要将字符串分离为 2+跳转次数 个子串
            $httpArr = explode("\r\n\r\n", $html, 2 + $httpinfo['redirect_count']);
            //倒数第二段是服务器最后一次response的http头
            $header = $httpArr[count($httpArr) - 2];
            //倒数第一段是服务器最后一次response的内容
            $body = $httpArr[count($httpArr) - 1];
            $header.="\r\n";

            //获取最后一次response的header信息
            preg_match_all('/([a-z0-9-_]+):\s*([^\r\n]+)\r\n/i', $header, $matches);
            if (!empty($matches) && count($matches) == 3 && !empty($matches[1]) && !empty($matches[1])) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    if (array_key_exists($i, $matches[2])) {
                        $responseHeaders[$matches[1][$i]] = $matches[2][$i];
                    }
                }
            }
            //获取图片后缀名

            if (0 < preg_match('{(?:[^\/\\\\]+)\.(jpg|jpeg|gif|png|bmp)$}i', $url, $matches)) {
                $originalfilename = $matches[0];
                $ext = $matches[1];
            } else {
                if (array_key_exists('Content-Type', $responseHeaders) || array_key_exists('content-type', $responseHeaders)) {
                    if (0 < preg_match('{image/(\w+)}i', $responseHeaders['Content-Type'], $extmatches)) {
                        $ext = $extmatches[1];
                    }
                    if (0 < preg_match('{image/(\w+)}i', $responseHeaders['content-type'], $extmatches)) {
                        $ext = $extmatches[1];
                    }
                }
            }
            //保存文件
            if (!empty($ext)) {
                $filename  = time().rand(11111,99999);
                //如果目录不存在，则先要创建目录
                Helper::makedir($filepath);
                $filepath .= $filename.".$ext";
                $local_file = fopen($filepath, 'w');
                if (false !== $local_file) {
                    if (false !== fwrite($local_file, $body)) {
                        fclose($local_file);
                        $sizeinfo = getimagesize($filepath);
                        $md5 = md5_file($filepath);
                        return array('filepath' => realpath($filepath), 'width' => $sizeinfo[0], 'height' => $sizeinfo[1], 'orginalfilename' => $originalfilename, 'filename' => pathinfo($filepath, PATHINFO_BASENAME),'md5'=>$md5);
                    }
                }
            }
        }
        return false;
    }



}