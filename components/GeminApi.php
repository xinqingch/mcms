<?php

namespace app\components;
use app\models\ApiLog;
use Yii;
use app\models\Helper;

class GeminApi
{
    const API_URL_PREFIX = 'https://generativelanguage.googleapis.com/v1beta/models/';

    private $apikey = "AIzaSyATUcwumTunfAzcCz6TUdBBjo4XSXFIoq4"; // 密钥

    private $apimodel='gemini-1.5-flash-latest';

    private $apiversion='2024-02-01';

    public function __construct($options)
    {
        $this->apikey = isset($options['apikey'])?$options['apikey']:'';
        $this->apimodel = isset($options['apimodel'])?$options['apimodel']:'';
    }
    /**
     * 发送聊天信息
     * 格式{"contents":[{"parts":[{"text":"Explain how AI works"}]}]}
     * @param $request post信息
     * @return bool
     */
    public  function chat($request)
    {
        $data =[];
        $url = self::API_URL_PREFIX.$this->apimodel.':generateContent?key='.$this->apikey;
        $header =self::getHeader();
        $request = json_encode($request);
        $md5 =md5($request);
        $cachedata = Yii::$app->cache->get($md5);
        if(empty($cachedata)){
            list($returnCode, $returnContent) = Helper::http_post($url,$request, $header);
            if($returnCode==200){
                $data =json_decode($returnContent,true);
                //API查询日志
                $apilog = new ApiLog();
                $adddata=[
                    'url'=>$url,
                    'postdata'=>$request,
                    'data'=>serialize($data),
                    'inputtime'=>time()
                ];
                $apilog->add($adddata);
                Yii::$app->cache->set($md5,$data,3600*24);

            }
        }else{
            $data =  $cachedata;
        }
       // dump($data['choices']);exit;

        return $data;
    }

    private function getHeader($post=''){
        if(empty($post)){
            $header = array (
                //"Referer:https://members.helium10.com/",
                "Content-Type: application/json",
                //'api-key:'.$this->apikey,
                //'Accept: */*',
                //'Accept-Language:zh-CN,zh;q=0.9',
                //'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            );
        }else{
            $header = array (
                //"Referer:https://members.helium10.com/",
                "Content-Type: application/json",
                //'api-key:'.$this->apikey,
                //'Accept: */*',
                //'Accept-Language:zh-CN,zh;q=0.9',
                'Content-Length: ' . strlen($post),
                //'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            );
        }

        return $header;
    }


}
