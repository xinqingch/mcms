<?php

return [
    'adminEmail' => 'admin@example.com',
    'mailType'=>'smtp',//可设置为smtp或phpmail
    'uploadPath'=>'uploads',//上传目录
    'upfiletype'=>'|jpg|jpeg|gif|png|bmp|doc|zip|rar|pdf|docs|swf|',
    'uppictype'=>'|jpg|gif|png|bmp|',
    'upload_max_fileSize'=>'2000000',
    'user.passwordResetTokenExpire' =>3600,
    'mailconfig'=>array(
        'Host'=>'smtp.exmail.qq.com',
        'Port'=>25,
        'SMTPAuth'=>false,
        'From'=>'devel@zeeeda.com',
        'FromName'=>'Morven',
        'Username'=>'devel@zeeeda.com',
        'SMTPSecure'=>'',
        'Password'=>'admin',
        'CharSet'=>'UTF-8',
        'ContentType'=>'text/html',
    ),
    'mobconfig'=>array(
        'Host'=>'http://106.ihuyi.cn/webservice/sms.php?method=Submit',//短信接口配置
        'Port'=>'80',
        'username'=>'cf_guojiazi',
        'password'=>'gjz16881',
        'md5'=>false,
    ),
    'mobilesms'=>'3',//手机接口商(0为商脉,1为商翼通3互亿无线)
    'domains' => array(
        'home'    => 'https://www.066810.com',
        'res'    => 'https://res.066810.com',
        'image'  => 'https://api.066810.com',
    ),
    'tusms'=>array(
        'Host'=>'http://sdk.open.api.igexin.com/apiex.htm',//推送接口
        'AppID'=> 'f8SH5CEEsI7G16Hapm2K55',
        'AppKey'=>'XBi8leJN6sAOmiI9GlSIk4',
        'AppSecret'=>'3G7nv8VtGH7BsKBYkrkwy6',
        'MasterSecret'=>'Y9CrGNrqJzAjtFKFuGWHH7'
    ),
    'wx_api'=>array(
        'AppID'=>'wx6947b5434197e793',//微信接口
        'AppSecret'=>'bb5e39f398353a6f974c8a1c67fc2caa',
        'mch_id'=>'33423423',
    ),
    'w_api'=>array(//推送接口
        'Host'=>'http://sdk.open.api.igexin.com/apiex.htm',
        'AppID'=> 'vO8aAwWaw28xoEMJYIB0M5',
        'AppKey'=>'dfkvTOay7a8GwWvCbTcbJ6',
        'AppSecret'=>'lEawJChh9S8if9huOZPaJ9',
        'MasterSecret'=>'PO2xN5uTIU9iswVaNI8g24'
    ),
    'v_api'=>array(//推送接口
        'Host'=>'http://sdk.open.api.igexin.com/apiex.htm',
        'AppID'=> '4ymQiFhFqe851yx0TzVRH1',
        'AppKey'=>'TC4uNEPwYfAlprenrRK099',
        'AppSecret'=>'lEawJChh9S8if9huOZPaJ9',
        'MasterSecret'=>'0hsFBZqPON6mdnqd77FWl9'
    ),
    'Jpush'=>array(//极光推送
        'app_key'=>'8ffdc739740780a4c4840b77',
        'master_secret'=>'e7658801eddf67e6500c222b'
    ),
    'alipay'=>array(
        'gatewayUrl'=>'https://openapi.alipay.com/gateway.do',
        'appId'=>'2019051664995396',
        'charset'=>'UTF-8',
        'format'=>'json',
        'signType'=>'RSA2',
        'rsaPrivateKey'=>'MIIEpAIBAAKCAQEA1V/tln6RZjhuzR7eHy4knswa06d78fStHq9vvGcFodG6rDl0najHlHphfwe3jinQ/p1qEt0aGD8P3HE2nYn3nf79u7Vu4jBRXOf4g5hNk/t2+69L/dfYZbVSe0JszI2TiY10GrLhD2BJBUnBb8/pol0ZIY2W/DNxDqBCXyodCSadwpnFfX87US19mDZeUw4VcjtWyc3R3qQsCCMqN9j4c9D2BQTkxYZ4J2bI9kwXNuUIqoUsawG/5CFJaC6TGdmX47g9YcwYawDtzXSxUk9HhUBzdxzwNbYPQnqHpwqUtGORkRbj8C9HEey/Tvb2y7DlFCAcaB26tDdheC+GIP8bXwIDAQABAoIBABTMSOhGZf3Eumgb/iKj6MXhtyuyQ46N/uHiz81ZbV8chkmLQCat8OY0F5S+N9IPmWN4DILSMlzyqKUgE+a/L/eihzDoumops4SOx9Zr3gPymuJlb87KXzlqtyN0kg5OLndV5l9D2FQbWoK9cbFoXqmI0Y5HstPaX8bBMDb+b94YS+nhhut2tgucopITrdhvqs4MYw8AaPphXCkWVlVqSwZriSAyeY1JVVoDH9Vda0bB3nr0V/qKVwGXVh2TBaFrmFVp/klQqA4kK74WmZ3fmTZvMSwu52EQjcVvRW6G78mVCAX3spuwnOVCZWp95sKeyzs++bYsFJVaUjELk+20kyECgYEA8aCjSTAeNp+8/ZEHLqyu958Ga/tCU0AYlkNxAM6ioZFRxyyj/hP3BiWgLVhZJcrHacohEFsCsg0dgzlr93IkXRODdXnbRjwtkP0Y0aKtC+djoT8Lhh8SJL8e1leKBirLxf0KI7OA3cSSOoMh8IBuIeqGHbYdX3vdBolND2onqUMCgYEA4hES06BZbHmMJQdqLgrRwwayEU2vPhERA3nlUiMiw9xNgg1LMMMT6H7KipsDbaXwNLl8MoyeAp8i4lvrWzJRnOB2rSnd2cPlZql45mZT4e1a/lOi/B+erDyftJrUJBO9PcCf4j7L4hgAe5+d1L1+KN8iNkYMG68E7up8UDDPZbUCgYEAtM0dwbMGuJr4oMg3lp5SYimVdZFSRNcOTsnyMcds+/awOZhWsdUgn3HiFGwqcNP2OVutN/7R2odj0QBToJnBSgBC+tGO2VRISFiKjLrsP58J9usk5Vw0iFiWa46fUhQN3H2Ga8Zyo/7l6HCdIcgIIMrLRkoyWnNlpPFyPxmQyd8CgYEA0tup+8psnkkg9sjbuOZOkOIF5S3YbsPsYpmn090B6D3r7YoIwAq03v6kXHQJ1pQYYJVBysRt/XQBTbD+7akZhoG3L/0E+MFHj2IzanO3eduyK9ZHB3NWxMAnFoXzqVLgCGFKv/RipxhMGwLebDfzHJxDhOwBDzFIILCGEyXzzKECgYBpUsFxex1pZYWU9ohWUTeP0adiBXsVnsaCQX0JRfuvMGtWEm5GU4Foq/rDpJ0qvBL/1qJpIOqFA5juXCMfiE5ClWH/8fmgf/a96ebhKNFCECb4dYX0SE6CdrPiV91hZb1bc+vZ3ovlCDBukdpEDgZdBWYumPm6V03KBSRYfmgvjg==',
        'alipayrsaPublicKey'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArqMdzSBVodNmTNqJjUV3SkFmlY4C2b0gkvdjvfOQdy4C/QqMZwZ+a9fXxqkHkW6EfTlKmw2n1i2e38aWgX39GMvE1gu+qO20NuW16Wts/rh7hYHFP7xLKInFMgbuylAt8qlQs0DZNxqeg3/dbwOa0OkSwtl725ZkkfO12ZVEQU9ImakEuqRvxJ1kH2tIGh4A0PUQWNXzygRRkT0bYw93mDFUGpLyAj9+fbF2yv0SwaiFJUXz2mlQrtNqv0Wei47BCb4SFQeWg5uUHCu6Ub7Fg7kmxp7vwaFUrczOBoonCHfyIooFou2uVP5XWFeddMR+Bid516QHKVLkCXr3BWYhlwIDAQAB',
    ),
    'jdapi'=> [
        'appkey' => '0c0588d584428b54d66e42aecc3a0ac9', // AppId （京东联盟的appkey）
        'appSecret' => '5d7e50fac36945edb1c62a282dc5ca8b', // 密钥 （京东联盟的appSecret）
        'unionId' => '2019626528', // 联盟ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'positionId' => '4100844882', // 推广位ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'siteId' => '4100523453', // 网站ID, （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'apithId' => '',  // 第三方网站Apith的appid （可选，不使用apith的，可以不用填写）
        'apithKey' => '', // 第三方网站Apith的appSecret (可选，不使用apith的，可以不用填写)
        'jyCode' => '', // 京东京佣的API授权调用code (可选，不使用京佣的，可以不用填写)
        'isCurl' => true // 设置为true的话，强制使用php的curl，为false的话，在swoole cli环境下自动启用 http协程客户端
    ],
    'vipjdapi'=> [
        'appkey' => '0c0588d584428b54d66e42aecc3a0ac9', // AppId （京东联盟的appkey）
        'appSecret' => '5d7e50fac36945edb1c62a282dc5ca8b', // 密钥 （京东联盟的appSecret）
        'unionId' => '2019626528', // 联盟ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'positionId' => '3004872799', // 推广位ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'siteId' => '4100844882', // 网站ID, （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        //'appkey' => 'e84733d551e84813fd31bd5b2babfcec', // AppId （京东联盟的appkey）
        //'appSecret' => '0e2822efe3a74ea0b2f1e5bd031fd33a', // 密钥 （京东联盟的appSecret）
        //'unionId' => '2019626528', // 联盟ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        // 'positionId' => '4100844881', // 推广位ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        //'siteId' => '4100523453', // 网站ID, （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        //'appkey' => 'bd8beccca478b4755fb7de83552093eb', // AppId （京东联盟的appkey）
        //'appSecret' => 'a6788f1ada8f42c7bc29b39571825fbd', // 密钥 （京东联盟的appSecret）
        //'unionId' => '27340', // 联盟ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        // 'positionId' => '3003880008', // 推广位ID （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        //'siteId' => '4100523453', // 网站ID, （如果使用京东联盟的，填京东联盟的，使用京佣的填京佣的）
        'apithId' => '',  // 第三方网站Apith的appid （可选，不使用apith的，可以不用填写）
        'apithKey' => '', // 第三方网站Apith的appSecret (可选，不使用apith的，可以不用填写)
        'jyCode' => '', // 京东京佣的API授权调用code (可选，不使用京佣的，可以不用填写)
        'isCurl' => true // 设置为true的话，强制使用php的curl，为false的话，在swoole cli环境下自动启用 http协程客户端
    ],
    'paiapi'=>[
        'Appid'=> 'bc16d300-b10f-46ec-a940-7a71a8addc17',
        'AppSecret'=>'a9b854cf-87ab-4f91-9e24-e7d0b26bdb10',
    ],
    'secretKey'=>'9Q46gfd89HGGR34r23',
    'domain' => 'http://www.066810.com/',
    'ver'=>'20201201001',//版本
];
