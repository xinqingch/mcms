<?php
/*
 * @description: 百度实现类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:33:53
 */

namespace app\components\translates\translate;


class YoudaoTranslate extends AbTranslate implements ITranslate
{
    public $appid;
    public $key;

    public function __construct($opt)
    {
        foreach ($opt as $k => $v) {
            if(property_exists($this,$k)) {
                $this->$k = $v;
            }
        }
    }

    public function translate()
    {

        $salt = rand(1000000000, 9999999999);
        $curtime = time();
        $signStr = $this->appid . $this->truncate($this->text) . $salt . $curtime . $this->key;
        $sign = hash("sha256", $signStr);
        $text = urlencode($this->text);

        // https://fanyi-api.baidu.com/api/trans/vip/translate
        $url = "https://openapi.youdao.com/api/trans/vip/translate?q={$text}&appid={$this->appid}&salt={$salt}&from={$this->source}&to={$this->target}&sign={$sign}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        $sentencesArray = json_decode($result, true);
        $sentences = "";
        foreach ($sentencesArray['trans_result'] as $k => $v) {
            $sentences .= ucwords($v['dst']);
        }
        $this->text  = $sentences;
    }

    function create_guid(){
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);
        $dec_hex = dechex($a_dec* 1000000);
        $sec_hex = dechex($a_sec);
        ensure_length($dec_hex, 5);
        ensure_length($sec_hex, 6);
        $guid = "";
        $guid .= $dec_hex;
        $guid .= create_guid_section(3);
        $guid .= '-';
        $guid .= create_guid_section(4);
        $guid .= '-';
        $guid .= create_guid_section(4);
        $guid .= '-';
        $guid .= create_guid_section(4);
        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= create_guid_section(6);
        return $guid;
    }

    function create_guid_section($characters){
        $return = "";
        for($i = 0; $i < $characters; $i++)
        {
            $return .= dechex(mt_rand(0,15));
        }
        return $return;
    }

    public function truncate($q) {
        $len = abslength($q);
        return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
    }

    function abslength($str)
    {
        if(empty($str)){
            return 0;
        }
        if(function_exists('mb_strlen')){
            return mb_strlen($str,'utf-8');
        }
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }

    function ensure_length(&$string, $length){
        $strlen = strlen($string);
        if($strlen < $length)
        {
            $string = str_pad($string, $length, "0");
        }
        else if($strlen > $length)
        {
            $string = substr($string, 0, $length);
        }
    }
}
