<?php
namespace Admin\Services;

class MenuServices {

    public static function getMenus() {
        return self::getAdminMenu();
        return self::getAgentMenu();
    }

    public static function getAdminMenu() {

        return [
            [
                'name' => '商品管理',
                'code' => 'Weixin',
                'icon' => '',
                'sub_menu' => [
                    [
                        'name' => '商品列表',
                        'url' => U('AdminGoods/index'),
                    ],
                ]
            ],
            [
                'name' => '代理销售中心',
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
        ];
    }

    public static function getAgentMenu() {
        
    }
}