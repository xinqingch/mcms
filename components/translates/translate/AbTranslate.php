<?php
/*
 * @description: 翻译抽象类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:09:41
 */

namespace app\components\translates\translate;

abstract class AbTranslate
{
    /**翻译后内容 */
    public $text = '';
    /**目标语言 */
    public $target;
    /**源语言 */
    public $source;
    /**具体方法 */
    public function run() {
        return $this->text;
    }
}
