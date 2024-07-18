<?php
namespace app\models;

use Yii;

class DataCache
{
    public $user = 'all'; //用户名
    public $status = 'all'; //状态态
    public $keyPrefix = 'cache_';
    public $res = 0;
    public $sql;//SQL语句
    public $tabname;
    public $data;


    public function getCache(){
        $keyname = $this->getKeyname();
        $data = Yii::$app->cache->get($keyname);
        return $data;
    }
    /**
     * 写入数据缓存
     * @param $data
     * @param int $time
     */
    public function set($data,$time=3600){
        $keyname = $this->getKeyname();
        $data = Yii::$app->cache->set($keyname,$data,$time);
        return $data;
    }

    public function ins($arr){
        $keyname = $this->getKeyname();
        $data = Yii::$app->cache->get($keyname);
        $data[] = $arr;
        Yii::$app->cache->set($keyname,$this->data,3600);
        Yii::$app->cache->set($keyname.'_i',1,10);//用来判断是否还在持续插入
        return $this->data;
    }

    public function checkIns(){
        $keyname = $this->getKeyname();
        return Yii::$app->cache->get($keyname.'_i');
    }

    public function addfile($data){
        $keyname = $this->getKeyname();
        file_put_contents(dirname(__DIR__).'/log/'.$keyname.'.php', json_encode($data).'\r\n',FILE_APPEND);
        return $data;
    }

    public function delfile(){
        $keyname = $this->getKeyname();
        $file_path = dirname(__DIR__).'/log/'.$keyname.'.php';
        unlink($file_path);
        return true;
    }

    public function rfile(){
        $keyname = $this->getKeyname();
        $file_path = dirname(__DIR__).'/log/'.$keyname.'.php';
        $arr =[];
        if(file_exists($file_path)){
            $fp = fopen($file_path,"r");
            $str = "";
            $buffer = 1024;//每次读取 1024 字节
            while(!feof($fp)){//循环读取，直至读取完整个文件
                $str .= fread($fp,$buffer);
            }
            //echo $str;
            $arr = explode('\r\n',$str);
            foreach ((array)$arr as $key=>$value){
                $arr[$key] = Helper::object_to_array(json_decode($value));
            }
            fclose($fp);
        }
        return $arr;

    }

    public function delarray($arr,$num){
        $keyname = $this->getKeyname();
        $data = Yii::$app->cache->get($keyname);
        array_splice($data,0,$num);//删除数组中的数据
        $this->set($data);
        return $data;
    }

    /**
     * 删除缓存
     */
    public function del(){
        $keyname = $this->getKeyname();
        Yii::$app->cache->delete($keyname);
    }

    private function getKeyname(){
        return $this->keyPrefix.$this->tabname.'_'.$this->user.'_'.$this->status;

    }

    /**
     * 批量添加
     * @param $data
     * @throws \yii\db\Exception
     */
    public function batchInsert($data,$max=100){
        switch ($this->tabname){
            case 'mo_analysis_phone'://手机号码导入
                $userkey=['area','phone','inputtime'];//数据键
                foreach ($data as $key=>$value){
                    if($key<=$max){
                        $uservale[] =[$value['area'],$value['phone'],$value['inputtime']];
                    }
                }
                break;
            case 'mo_userphone':
                $userkey=['adminerId','user','phone','info','time'];//测试数据键
                $uservale=[];
                foreach ($data as $key=>$value){
                    if($key<=$max){
                        $uservale[] =[$value['adminerId'],$value['user'],$value['phone'],$value['info'],$value['time']];
                    }
                }
                break;
            case 'mo_proxy':
                $userkey=['adminerId','user','proxy_ip','proxy_port','proxy_user','proxy_pass','status','remark'];//测试数据键
                foreach ($data as $key=>$value){
                    if($key<=$max){
                        $uservale[] =[$value['adminerId'],$value['user'],$value['proxy_ip'],$value['proxy_port'],$value['proxy_user'],$value['proxy_pass'],0,$value['remark']];
                    }
                }
                break;
        }
        array_splice($data,0,$max);//插入数组中的数据
        $this->set($data);//重新写入数据
        $res = Yii::$app->db->createCommand()->batchInsert($this->tabname, $userkey, $uservale)->execute();//执行批量添加
        return $res;
    }


}
