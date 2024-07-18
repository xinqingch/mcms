<?php

namespace app\models;

use Yii;

/**
 * 工具类
 */
class Helper {
	/**
	 * 
	 * @param number $errno 状态0无错误
	 * @param string $errstr 错误信息
	 * @param unknown $result 返回信息
	 * @param string $message 文本信息
	 */
	public static function result($errno=0, $errstr='', $result=[], $message='') {
		$msg          = new \stdClass;
		$msg->errno   = $errno;
		$msg->errstr  = $errstr;
		$msg->result  = $result;
		$msg->message = $message;
		
		$json = json_encode($msg);
		header("Content-Type:application/json;charset=utf-8");
        $headers = Yii::$app->request->headers;//取头部
		$callback = Yii::$app->request->get('callback');
        $Encoding = $headers->get('Encoding');
        if($Encoding){
            $json = self::func_gzcompress($json);
        }
		if(!empty($callback)) {
			echo Yii::$app->request->get('callback'), '(', $json, ');';
		}
		else {
			echo $json;
		}
		exit();
	}
    /**
     * 
     * @param number $code 状态0无错误
     * @param string $message 文本信息
     * @param unknown $result 返回信息
     */
    public static function results($code=0,$message='',$result=[]) {
        $msg          = new \stdClass;
        $msg->code   = $code;
        $msg->message = $message;
        $msg->result  = $result;
        
        $json = json_encode($msg);
        header("Content-Type:application/json;charset=utf-8");
        $headers = Yii::$app->request->headers;//取头部
        $callback = Yii::$app->request->get('callback');
        $Encoding = $headers->get('Encoding');
        if($Encoding){
            $json = self::func_gzcompress($json);
        }
        if(!empty($callback)) {
            echo Yii::$app->request->get('callback'), '(', $json, ');';
        }
        else {
            echo $json;
        }
        exit();
    }

    /**
     *
     * @param number $errno 状态0无错误
     * @param string $errstr 错误信息
     * @param unknown $result 返回信息
     * @param string $message 文本信息
     */
    public static function tojson($message='') {
        $json = json_encode($message);
        header("Content-Type:application/json;charset=utf-8");
        $headers = Yii::$app->request->headers;//取头部
        $callback = Yii::$app->request->get('callback');
        $Encoding = $headers->get('Encoding');
        if($Encoding){
            $json = self::func_gzcompress($json);
        }
        if(!empty($callback)) {
            echo Yii::$app->request->get('callback'), '(', $json, ');';
        }
        else {
            echo $json;
        }
        exit();
    }

	/**
	 * 读取开发者验证
	 * @param $account
	 * @param $password
	 * @return int
	 */
	public static function getDev($account,$password)
	{
		$sign = '';
		$key = 'dev_'.$account.$password;
		if($account == 'test' && $password=='123456' ){
			$data = Yii::$app->cache->get($key);
			if($data){
				$sign = $data;
			}else{
				$sign = md5($account.$password.time());
				Yii::$app->cache->set($key, $sign,3600*24*365);//保存365天
			}
			return $sign;
		}else{
			return false;
		}

	}

	/**
	 * 检查开发者验证
	 * @param $sign
	 * @return bool
	 */
	public static function checkDev($sign){
		$account = 'test';
		$password = '123456';
		$key = 'dev_'.$account.$password;
		$data = Yii::$app->cache->get($key);
		if($data == $sign){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 检查token是否有效
	 * @param $token
	 * @return bool
	 */
	public static function checkToken($token){
		$data = Yii::$app->cache->get($token);
		//var_dump($token);exit;
		$key = 'memberinfo_'.$data['member_id'];
		$memberdata = Yii::$app->cache->get($key);
		if(!empty($memberdata)){
			if( $memberdata['token'] == $token){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/**
	 * 检查companyId是否有效
	 * @param $companyId
	 * @return bool
	 */
	public static function checkCompany($companyId){
		$key = 'company_'.$companyId;
		$memberdata = Yii::$app->cache->get($key);
		if(!empty($memberdata)){
			if( $memberdata['companyId'] == $companyId){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/**
	 * 数组重新排序
	 * @param $arr 数组
	 * @param $keys 关键字
	 * @param $type 排序方式	 *
	 * return array
	 */
	public static function array_sort($arr,$keys,$type='asc'){
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[] = $arr[$k];
		}
		return $new_array;
	}

    /**
     * 创建文件夹
     * @param $path
     * @param int $permissions
     * @return bool
     */
    public static function Makedir ( $path, $permissions = 0777 )
    {
        $result = array();
        while( $path != dirname( $path) ) {
            array_push( $result, $path );
            $path = dirname( $path );
        }
        sort( $result );

        foreach( $result as $directory ) {
            if ( !file_exists( $directory ) ) mkdir( $directory, $permissions );
            //if ( !file_exists( $directory ) ) return false;
        }
        return true;
    }


    /**
     *  检查文件类型
     * @param       string      filename            文件名
     * @param       string      limit_ext_types     允许的文件类型，用|包围的类型如：|gif|txt|
     * @return      string
     */
    public static function check_file_type($filename, $limit_ext_types = ''){
        $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
        if ($limit_ext_types &&
            stristr($limit_ext_types, '|' . $extname . '|') === false){
            return '';
        }

        $str = $format = '';

        $file = @fopen($filename, 'rb');
        if ($file){
            $str = @fread($file, 0x400); // 读取前 1024 个字节
            @fclose($file);
        }
        else{
            $format=$extname;
        }

        if ($format == '' && strlen($str) >= 2 ){

            if (substr($str, 0, 4) == 'MThd' && $extname != 'txt'){
                $format = 'mid';
            }
            elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav'){
                $format = 'wav';
            }
            elseif (substr($str ,0, 3) == "\xFF\xD8\xFF" || $extname =='jpeg'){
                $format = 'jpg';
            }
            elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt'){
                $format = 'gif';
            }
            elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A"){
                $format = 'png';
            }
            elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt'){
                $format = 'bmp';
            }
            elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS')
                && $extname != 'txt'){
                $format = 'swf';
            }
            elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0"){   // D0CF11E == DOCFILE == Microsoft Office Document
                if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00"
                    || $extname == 'doc'){
                    $format = 'doc';
                }
                elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls'){
                    $format = 'xls';
                }
                elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF"
                    || $extname == 'ppt'){
                    $format = 'ppt';
                }
            }
            elseif (substr($str ,0, 4) == "PK\x03\x04"){
                $format = 'zip';
            }
            elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt'){
                $format = 'rar';
            }
            elseif (substr($str ,0, 4) == "\x25PDF"){
                $format = 'pdf';
            }
            elseif (substr($str ,0, 3) == "\x30\x82\x0A"){
                $format = 'cert';
            }
            elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt'){
                $format = 'chm';
            }
            elseif (substr($str ,0, 4) == "\x2ERMF"){
                $format = 'rm';
            }
            elseif ($extname == 'sql'){
                $format = 'sql';
            }
            elseif ($extname == 'txt'){
                $format = 'txt';
            }
        }

        if ($limit_ext_types &&
            stristr($limit_ext_types, '|' . $format . '|') === false){
            $format = '';
        }

        return $format;
    }


    /**
     * @name php获取中文字符拼音首字母
     * @param $str
     * @return null|string
     */
    public static function getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'GB2312//IGNORE', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    public static function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }

        return (object)$arr;
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    public static function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }

    /**
     * 输出错误信息
     * @param $model
     * @return bool
     */
    public static function modelerror($model){
        if(is_string($model)){
            return $model;
        }else{
            foreach ($model as $val){
                return $val['0'];
                exit;
            }
        }


        return true;
    }

    /**
     * 写日志
     * @param $file
     * @param $data
     * @return bool
     */
    public static  function log($file,$data){
        $log_file = $file;
        $content =var_export($data,TRUE);
        $content .= "\r\n\n";
        file_put_contents($log_file,$content, FILE_APPEND);
        return true;
    }


    /**
     * 判断字符串是否base64编码
     */
    public static function func_is_base64($str)
    {
        return $str == base64_encode(base64_decode($str)) ? true : false;
    }
    /**
     * 压缩内容
     */
    public static function func_gzcompress($str, $level = 9)
    {
        if (!self::func_is_base64($str)) {
            return base64_encode(gzcompress($str, $level));
        }
        return $str;
    }
    /**
     * 解压内容
     */
    public static function func_gzuncompress($str)
    {
        if (self::func_is_base64($str)) {
            return gzuncompress(base64_decode($str));
        }
        return $str;

    }

    /**
     * GET 请求
     * @param string $url
     */
    public static function http_get($url,$header=array()){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        //curl_setopt ($oCurl, CURLOPT_HTTPHEADER, array('CLIENT-IP:47.106.158.123', 'X-FORWARDED-FOR:47.106.158.123'));
        if($header){
            curl_setopt($oCurl,CURLOPT_HTTPHEADER,$header);
            curl_setopt($oCurl, CURLOPT_HEADER, false);
            curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        }
        //curl_setopt($oCurl, CURLOPT_REFERER, 'http://m.leisu.com');//模拟来路
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl,CURLOPT_ENCODING,'');
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        // 设置连接超时时间，单位是秒
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 5);
        // 设置请求超时时间，单位是秒
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);




        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        //var_dump($sContent);
        //var_dump($aStatus);
        $data['sContent'] = $sContent;
        $data['aStatus'] = $aStatus;
        //if(intval($aStatus["http_code"])==200){
            return $data;
        //}else{
            //return false;
        //}
    }

    public static function http_post($url, $post,$header=array())
    {
        $ch = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //dump($response);
        return array($httpCode, $response);
    }

    public static function Rand_IP(){

      $ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
      $ip3id= round(rand(600000, 2550000) / 10000);
      $ip4id= round(rand(600000, 2550000) / 10000);
      //下面是第二种方法，在以下数据中随机抽取
      $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
      $randarr= mt_rand(0,count($arr_1)-1);
     $ip1id = $arr_1[$randarr];
     return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
     }

    /**
     * 字符截取 支持UTF8/GBK
     * @param $string
     * @param $length
     * @param $dot
     */
    public static function str_cut($string, $length, $dot = '') {
        $CHARSET = 'utf-8';
        $strlen = strlen($string);
        if($strlen <= $length) return $string;
        $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $strcut = '';
        if(strtolower($CHARSET) == 'utf-8') {
            $length = intval($length-strlen($dot)-$length/3);
            $n = $tn = $noc = 0;
            while($n < strlen($string)) {
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }
                if($noc >= $length) {
                    break;
                }
            }
            if($noc > $length) {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
            $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
        }
        else {
            $dotlen = strlen($dot);
            $maxi = $length - $dotlen - 1;
            $current_str = '';
            $search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
            $replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
            $search_flip = array_flip($search_arr);
            for ($i = 0; $i < $maxi; $i++) {
                $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
                if (in_array($current_str, $search_arr)) {
                    $key = $search_flip[$current_str];
                    $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
                }
                $strcut .= $current_str;
            }
        }
        return $strcut.$dot;
    }

    /**
     * 显示缩略图
     * @param $url
     * @param int $size  50，160，200，300，600
     * @return string
     */
    public static function  Thumb($url,$size=50){
        $ext = Helper::check_file_type($url,Yii::$app->params['upfiletype']);
        if(stripos($url,"https://")!==FALSE || stripos($url,"http://")!==FALSE || stripos($url,"api.qiu006.com")!==FALSE ) {
            $pic = $url . '_' . $size . 'x' . $size . '.' . $ext;//为图片地址补全并输出
        }elseif (stripos($url,"x")!==FALSE ){
            $pic = $url;
        }else{
            $pic = Yii::$app->params['domains']['image'] . $url . '_' . $size . 'x' . $size . '.' . $ext;//为图片地址补全并输出
        }
        return $pic;
    }

    /**
     * 获取IP
     * return $nowurl;
     */
    public static function GetIP() {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }

    /**
     * 显示中间字符星号
     * @param $user_name
     * @return mixed|string
     */
    public static function substr_star($user_name){
        $strlen = mb_strlen($user_name, 'utf-8');
        //如果字符创长度小于2，不做任何处理
        if($strlen<2){
            return $user_name;

        }else{
        //mb_substr — 获取字符串的部分
        $firstStr = mb_substr($user_name, 0, 4, 'utf-8');
        $lastStr = mb_substr($user_name, -4, 4, 'utf-8');
        //str_repeat — 重复一个字符串
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;

        }

    }

    /**
     * 多维数组，根据某个特定字段过滤重复值
     * @param array $arr 需要过滤值的原多维数组
     * @param string $filterKey 被过滤的键值
     * @return array
     */
    public static function remove_duplicate($arr = [], $filterKey = '',$str=null)
    {
        if (empty($arr) || empty($filterKey)) {
            return $arr;
        } else {
            //声明一个目标数组
            $res = [];

            foreach ($arr as $item) {
                //查看是否存在重复项
                if($str==null){
                    $key = $item[$filterKey];
                }else{
                    $key = self::str_cut($item[$filterKey],$str);
                }

                if (isset($res[$key])) {
                    unset($item[$filterKey]);   //存在，销毁
                } else {
                    $res[$key] = $item;
                }
            }

            return $res;
        }
    }

}