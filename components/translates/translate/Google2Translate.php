<?php
/*
 * @description: 谷歌实现类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:33:53
 */

namespace app\components\translates\translate;


class Google2Translate extends AbTranslate implements ITranslate
{
    public function translate()
    {
        $url =  "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t";

        $fields = array('sl' => urlencode($this->source), 'tl' => urlencode($this->target), 'q' => urlencode($this->text));

        // URL-ify the data for the POST
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        rtrim($fields_string, '&');

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
        $this->text  = json_decode($result, true)[0][0][0];
    }
}
