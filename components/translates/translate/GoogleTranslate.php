<?php
/*
 * @description: 谷歌实现类
 * @Author: 8818190@qq.com
 * @Date: 2021-05-14 19:33:53
 */

namespace app\components\translates\translate;


class GoogleTranslate extends AbTranslate implements ITranslate
{
    public function translate()
    {
        $host = 'translate.google.cn';
        // $host='translate.google.com'; //国际
        $url = "https://{$host}/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";

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

        $sentencesArray = json_decode($result, true);
        $sentences = "";

        foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= isset($s["trans"]) ? $s["trans"] : '';
        }
        $this->text  =  $sentences;
    }
}
