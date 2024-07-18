<?php

namespace app\components;

class SignatureService
{
    private static $SECRET_KEY = "dSH33LDbG62B0yWHUgGjksXqBVbPF5WCUfeEazNgXFE="; // 密钥

    /**
     * 验证签名
     * @param $request 验证信息
     * @return bool
     */
    public static function verifySignature($request)
    {
        $receivedSignature = $request['signature'];
        unset($request['signature']);
        // 创建一个关联数组并按字典顺序排序参数
        ksort($request); // 按键名排序

        // 计算签名
        $calculatedSignature = self::calculateSignature($request);

        // 比较签名
        return hash_equals($calculatedSignature, $receivedSignature);
    }

    /**
     * 创建签名
     * @param $params
     * @return string
     */
    public static function calculateSignature($params)
    {
        // 构建原始字符串
        $data = '';
        foreach ($params as $key => $value) {
            $data .= $key . '=' . rawurlencode($value) . '&';
        }
        $data .= 'key=' . rawurlencode(self::$SECRET_KEY);

        // 计算 MD5 签名
        $signature = md5($data);

        return $signature;
    }
}
