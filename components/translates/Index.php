<?php
/*
 * @description: 终端样例
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:09:41
 */
namespace app\components\translates;
use app\components\translates\Translatectory;

class IndexController
{
    function actionIndex($text = '') {
        //启动工厂
        $model = new Translatectory();

        //小牛翻译、百度翻译通过构造方法传递账号
        $basic = [
            'apikey' => 'xxxx', //小牛翻译apikey
            // 'appid' => 'xxx', //百度翻译appid
            // 'key' => 'xxx',//百度翻译key
        ];

        //获得小牛翻译具体
        $form = $model->NiuTranslate($basic);
        //百度翻译
        // $form = $model->BaiduTranslate($basic);
        //谷歌翻译1
        // $form = $model->GoogleTranslate();
        //谷歌翻译2
        // $form = $model->Google2Translate();

        $form->target = "en"; //目标语言en-英语，其他语言编号按照国际通用编号，具体不同翻译可能会有差异，请在各自的官网进行查询，
        $form->source = "zh"; //源语言 zh-中文，其他语言编号按照国际通用编号，具体不同翻译可能会有差异，请在各自的官网进行查询
        $form->text = $text;

        //生产
        $form->translate();
        //输出翻译
        return $form->run();
    }
}