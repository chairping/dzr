<?php

return [

    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'        => 'zh-cn', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
    'LANG_SWITCH_ON' => true,   // 开启语言包功能

    "TYPE_NAME" => array("1" => "一级代理用户", "2" => "平台管理员", "3" => "农民"),
    
    'MENU' => [
            [
                'name' => '商品管理',
                'code' => 'Weixin',
                'icon' => '',
                'sub_menu' => [
                    [
                        'name' => '公众号信息管理',
                        'url' => U('Public/index'),
                    ],

                ]
            ],
            [
                'name' => '景区代理管理',
                'code' => 'Weixin',
                'icon' => '',
                'sub_menu' => [
                    [
                        'name' => '公众号信息管理',
                        'url' => 'Weixin/Gzh/index',
                    ],

                ]
            ],
            [
                'name' => '提现管理',
                'code' => 'Weixin',
                'icon' => '',
                'sub_menu' => [
                    [
                        'name' => '公众号信息管理',
                        'url' => 'Weixin/Gzh/index',
                    ],

                ]
            ],


    ]

];

