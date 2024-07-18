<?php

namespace app\components;
use app\models\ApiLog;
use Yii;
use app\models\Helper;

class AzureApi
{
    const API_URL_PREFIX = 'https://analysisapi.openai.azure.com';
    private $apiurl;

    private $apikey = "3cd34861f0d54b319842e03ac77d4d5f"; // 密钥

    private $apiname;

    private $apimodel;

    private $apiversion='2024-02-01';

    public function __construct($options)
    {
        $this->apiurl = isset($options['apiurl'])?$options['apiurl']:self::API_URL_PREFIX;
        $this->apikey = isset($options['apikey'])?$options['apikey']:'';
        $this->apiname = isset($options['apiname'])?$options['apiname']:'';
        $this->apimodel = isset($options['apimodel'])?$options['apimodel']:'';
    }
    /**
     * 发送聊天信息
     * {\"prompt\": \"Once upon a time\"}
     * @param $request post信息
     * @return bool
     */
    public  function chat($request)
    {
        $data =[];
        $url = $this->apiurl.'/openai/deployments/'.$this->apiname.'/chat/completions?api-version='.$this->apiversion;
        $header =self::getHeader();
        $md5 =md5(serialize($request).$url);
        unset($request['asins']);
        $request = json_encode($request);
        $cachedata = Yii::$app->cache->get($md5);
        if(empty($cachedata)){
            list($returnCode, $returnContent) = Helper::http_post($url,$request, $header);
            //dump($returnContent);exit;
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
                Yii::$app->cache->set($md5,$data,3600*24*7);
            }else{
                $data =json_decode($returnContent,true);
            }
        }else{
            $data =  $cachedata;
        }
        //dump($data['choices']);exit;

        return $data;
    }

    private function getHeader($post=''){
        if(empty($post)){
            $header = array (
                //"Referer:https://members.helium10.com/",
                "Content-Type: application/json",
                'api-key:'.$this->apikey,
                //'Accept: */*',
                //'Accept-Language:zh-CN,zh;q=0.9',
                //'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            );
        }else{
            $header = array (
                //"Referer:https://members.helium10.com/",
                "Content-Type: application/json",
                'api-key:'.$this->apikey,
                //'Accept: */*',
                //'Accept-Language:zh-CN,zh;q=0.9',
                'Content-Length: ' . strlen($post),
                //'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            );
        }

        return $header;
    }




}
