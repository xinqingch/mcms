<?php
/*
 * @description: 具体工厂
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:09:41
 */

namespace app\components\translates;

use app\components\translates\translate\NiuTranslate;
use app\components\translates\translate\BaiduTranslate;
use app\components\translates\translate\YoudaoTranslate;
use app\components\translates\translate\GoogleTranslate;
use app\components\translates\translate\Google2Translate;


class Translatectory implements ITranslatectory
{
    //调用小牛翻译
    public function NiuTranslate($opt): NiuTranslate
    {
        return new NiuTranslate($opt);
    }
    //调用百度翻译
    public function BaiduTranslate($opt): BaiduTranslate
    {
        return new BaiduTranslate($opt);
    }
    //调用有道翻译
    public function YoudaoTranslate($opt): YoudaoTranslate
    {
        return new YoudaoTranslate($opt);
    }
    //调用谷歌翻译
    public function GoogleTranslate(): GoogleTranslate
    {
        return new GoogleTranslate();
    }
    //调用谷歌翻译
    public function Google2Translate(): Google2Translate
    {
        return new Google2Translate();
    }
}
