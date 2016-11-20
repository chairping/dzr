<?php
return array(
    //'配置�?=>'配置�?
    //禁止模块访问
    'MODULE_DENY_LIST'=>array('Common','Runtime'),

    "DB_NAME"=>'dzr',
    "DB_USER"=>'root',
    "DB_PWD"=>'111111',
    "DB_PREFIX"=>'dzr_',
    'DB_HOST'=>'127.0.0.1',
    'DB_TYPE'=>'mysql',
    'URL_HTML_SUFFIX'=>'',


//    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
//    'LANG_LIST'        => 'zh-cn，zh-tw', // 允许切换的语言列表 用逗号分隔
//    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
//    'LANG_SWITCH_ON' => true,   // 开启语言包功能



    //页面Trace
    'SHOW_PAGE_TRACE'=>false,

    //修改定界符（默认标签�?
    'TMPL_L_DELIM'=>'{',
    'TMPL_R_DELIM'=>'}',

    //标签加载
    'TAGLIB_PRE_LOAD'=>'html',
    'SESSION_OPTIONS' => array(
        //'type'=>'db',
        'expire'=>3600 * 10,//过期时间�?600
    ),

    //设置访问模块
    'MODULE_ALLOW_LIST'=>array('Home','Admin'),
    //默认模块，可以省去模块名输入
    'DEFAULT_MODULE'=>'Home',

    //启用路由功能
    'URL_ROUTER_ON'=>true,

    //配置路由规则
    'URL_ROUTE_RULES'=>array(
        'u/:id'=>'User/example2',
    ),
    //URL不区分大小写
    'URL_CASE_INSENSITIVE'=>true,

    //设置伪静态后缀，默认为html
// 		'URL_HTML_SUFFIX'=>'shtml',

    //如果设置为空，那么就任意后缀
// 		'URL_HTML_SUFFIX'=>'',

    //设置可以访问的伪静态后缀
    'URL_HTML_SUFFIX'=>'html|pdf|xml|tpl',

    //禁止访问的后缀
    'URL_DENY_SUFFIX'=>'ico|jpg',

    //重写模式
    'URL_MODEL'=>'2',

    //开启静态缓�?
    'HTML_CACHE_ON'=>	true,
    //全局缓存的过期时�?
    'HTML_CACHE_TIME'=>60,
    //缓存的后缀
    'HTML_CACHE_SUFFIX'=>'.html',
    //缓存规则
//    'HTML_CACHE_RULES'=>array(
//// 			'User:index17'=>'123',
//// 			'User:index17'=>array('{:module}_{:controller}_{:action}_{id}',60),
//        'User:index17'=>array('{:module}/{:controller}/{:action}/{id}',60),
    //定义模板常量
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__.'/Public/static',
        '__CSS__' => __ROOT__.'/Public/css',
        '__IMG__' => __ROOT__.'/Public/images',
        '__JS__' => __ROOT__.'/Public/js',
        '__Plugins__' => __ROOT__.'/Public/plugins',
        '__Fonts__' => __ROOT__.'/Public/fonts',
        '__Uploads__' => __ROOT__.'/Uploads',
        '__Public__' => __ROOT__.'/Public',
        '__UPLOADIMG__' => __ROOT__.'/Public/uploadimg',

        '__HCSS__' => __ROOT__.'/Public/Home/css',
        '__HIMG__' => __ROOT__.'/Public/Home/img',
        '__HIMGS__' => __ROOT__.'/Public/Home/images',
        '__HJS__' => __ROOT__.'/Public/Home/js',

        '__HSCSS__' => __ROOT__.'/Public/Home/Shop/css',
        '__HSIMG__' => __ROOT__.'/Public/Home/Shop/images',
        '__HSJS__' => __ROOT__.'/Public/Home/Shop/js',
        '__HKind__' => __ROOT__.'/Public/kindeditor',

    ),

    //全局配置
    "SUC_CODE"             => "success",
    "ERROR_CODE"           => "error",
    "SIGN"           => "sign",

    'ACCESS_KEY'=> 'cmy88wkcae83ccmy',
    'ACCESS_IV'=>'cmy*5f-k',

    /*微信支付配置*/
    'WxPayConf_pub'=>array(
        'APPID' => 'wx95a5e2ac6d04c066',
        'APPSECRET' => '64f500e0c2194ce0e1649e91565303bb',
        'MCHID' => '您的商户ID',
        'KEY' => '商户秘钥',
        'JS_API_CALL_URL' => WEB_HOST.'/index.php/Home/WxJsAPI/jsApiCall',
        'SSLCERT_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_cert.pem',
        'SSLKEY_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_key.pem',
        'NOTIFY_URL' =>  WEB_HOST.'/index.php/Home/WxJsAPI/notify',
        'CURL_TIMEOUT' => 30
    )
);