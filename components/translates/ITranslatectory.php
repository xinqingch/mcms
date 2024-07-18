<?php
/*
 * @description: 工厂抽象
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:09:41
 */

namespace app\components\translates;

use app\components\translates\translate\NiuTranslate;
use app\components\translates\translate\BaiduTranslate;
use app\components\translates\translate\YoudaoTranslate;
use app\components\translates\translate\GoogleTranslate;
use app\components\translates\translate\Google2Translate;


interface ITranslatectory
{
    // 调用小牛翻译
    public function NiuTranslate($opt) : NiuTranslate;
    // 调用百度翻译
    public function BaiduTranslate($opt) : BaiduTranslate;
    // 调用有道翻译
    public function YoudaoTranslate($opt) : YoudaoTranslate;
    // 调用谷歌翻译
    public function GoogleTranslate() : GoogleTranslate;
    // 调用谷歌2翻译
    public function Google2Translate() : Google2Translate;
}

