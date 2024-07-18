<?php

if (!function_exists('dump')) {
    /**
     * 打印专用
     * @param array ...$param
     */
    function dump()
    {
        $args = func_get_args();
        foreach($args as $k => $arg){
            echo '<fieldset class="debug">
        <legend>'.($k+1).'</legend>';
            \yii\helpers\VarDumper::dump($arg, 10, true);
            echo '</fieldset>';
        }
        //exit(1);
    }
}

if (!function_exists('yiiUrl')) {
    /**
     * 创建url.
     *
     * @param $url string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiUrl($url)
    {
        return Yii::$app->urlManager->createUrl($url);
    }
}

if (!function_exists('yiiParams')) {
    /**
     * 获取yii配置参数.
     *
     * @param $key string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiParams($key)
    {
        return Yii::$app->params[$key];
    }
}

if (!function_exists('curl_post')) {
    /**
     * Send a POST requst using cURL
     * @param string $url to request
     * @param array $post values to send
     * @param array $options for cURL
     * @return string
     */
    function curl_post($url, array $post = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (!$result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        $aStatus = curl_getinfo($ch);
        //dump($aStatus);
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('curl_get')) {
    /**
     * Send a GET requst using cURL
     * @param string $url to request
     * @param array $get values to send
     * @param array $options for cURL
     * @return string
     */
    function curl_get($url, array $get = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url . (strpos($url, '?') === FALSE ? '?' : '') . http_build_query($get),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (!$result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('thumb')) {
    /**
     * Send a GET requst using cURL
     * @param string $url to request
     * @param array $w 缩略图大小 80，160，200，300，600
     * @param array $options for cURL
     * @return string
     */
    function thumb($url, $w=200)
    {
        $newurl = '';
        $urlarray =explode('.',$url);
        $newurl=$urlarray[0].'_'.$w.'.'.$urlarray[1];
        return $newurl;
    }
}