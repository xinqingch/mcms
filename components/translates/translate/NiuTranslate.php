<?php
/*
 * @description: 小牛实现类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:33:53
 */

namespace app\components\translates\translate;


class NiuTranslate extends AbTranslate implements ITranslate
{
    public $apikey;

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

        $text = urlencode($this->text);

        $url = "http://free.niutrans.com/NiuTransServer/translation?from={$this->source}&to={$this->target}&apikey={$this->apikey}&src_text={$text}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        $this->text  =  json_decode($result, true)['tgt_text'];
    }
}
