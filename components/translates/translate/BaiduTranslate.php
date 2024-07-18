<?php
/*
 * @description: 百度实现类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:33:53
 */

namespace app\components\translates\translate;


class BaiduTranslate extends AbTranslate implements ITranslate
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
        $sign = md5($this->appid . $this->text . $salt . $this->key);
        $text = urlencode($this->text);

        // https://fanyi-api.baidu.com/api/trans/vip/translate
        $url = "http://api.fanyi.baidu.com/api/trans/vip/translate?q={$text}&appid={$this->appid}&salt={$salt}&from={$this->source}&to={$this->target}&sign={$sign}";

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
}
