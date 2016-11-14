<?php
namespace Admin\Services;

class MenuServices {

    public static function getMenus() {
        return self::getAdminMenu();
//        return self::getAgentMenu();
    }

    public static function getAdminMenu() {
        $type = session('type');$type=2;
        if (in_array($type, array('1', '3'))) {
            //代理、农民
            return [
                [
                    'name' => '我的业绩',
                    'code' => 'Weixin',
                    'icon' => '',
                    'sub_menu' => [
                        [
                            'name' => '业绩列表',
                            'url' => U('AgentAchievement/index'),
//                            'url' => __APP__.'/admin.php/AgentAchievement/index',
                        ],
                    ]
                ],
                [
                    'name' => '管理中心',
                    'code' => 'Weixin',
                    'icon' => '',
                    'sub_menu' => [
                        [
                            'name' => '信息管理',
                            'url' => U('AgentInfo/index'),
//                            'url' => __APP__.'/admin.php/AgentInfo/index'
                        ],
                    ]
                ],
                
            ];
        } else {
            //平台管理员
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
                        [
                            'name' => '图片裁剪',
//                            'url' => U('AgentAchievement/index'),
                            'url' =>  U('AdminGoods/cropAvatar'),
                        ],
                    ]
                ],
                [
                    'name' => '代理销售中心',
                    'code' => 'Weixin',
                    'icon' => '',
                    'sub_menu' => [
                        [
                            'name' => '代理点列表',
                            'url' => U('AdminScenic/agentList'),
                        ],
                        [
                            'name' => '景区管理',
                            'url' => U('AdminScenic/index'),
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

    }
}