<?php
define('WEB_HOST', '这是您的网站域名地址');

return array(
	//'配置项'=>'配置值'

    //'配置项'=>'配置值'
    'LANG_SWITCH_ON'     =>     true,    //开启语言包功能
    'LANG_AUTO_DETECT'     =>     true, // 自动侦测语言
    'DEFAULT_LANG'         =>     'zh-cn', // 默认语言
    'LANG_LIST'            =>    'zh-cn', //必须写可允许的语言列表
//    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
    'LANG_SWITCH_PARAMETER' => 'language',
    
    "DELIVER_STATUS" => array("1" => "自取", "2" => "未发货", "3" => "已发货", "4" => "已收货"),


    /*微信支付配置*/
    'WxPayConf_pub'=>array(
        'APPID' => '您的APPID',
        'MCHID' => '您的商户ID',
        'KEY' => '商户秘钥',
        'APPSECRET' => '您的APPSECRET',
        'JS_API_CALL_URL' => WEB_HOST.'/index.php/Home/WxJsAPI/jsApiCall',
        'SSLCERT_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_cert.pem',
        'SSLKEY_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_key.pem',
        'NOTIFY_URL' =>  WEB_HOST.'/index.php/Home/WxJsAPI/notify',
        'CURL_TIMEOUT' => 30
    )


);