<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class CartsModel extends CommonModel {
    protected $tableName = "carts";

    /*
     * @author 曹梦瑶
     * 获取当前登录用户购物车内容
     */
    public function getInfo($type = 1) {
        $list = array();
        $user_id = getHomeUserID();
        if($user_id) {
            $list = $this->where(array(
                'user_id' => $user_id,
                'status' => 1,
                'type' => $type,
            ))
                ->order('update_time desc')
                ->select();
        }
        return $list;

    }

    /*
     * @author 曹梦瑶
     * 修改购物车状态
     */
    public function deleteByGoodsId($goods_id_arr) {
        if($goods_id_arr) {
            $is = $this->where(array(
                'goods_id' => array('in', $goods_id_arr),
                'user_id' => getHomeUserID()
            ))
                ->save(array(
                    'update_time' => time(),
                    'status' => 2
                ));
            if($is !== false) {
                return true;
            }
        }
        return false;
    }

    /*
  * @author 曹梦瑶
  * 加入购物车
  */
    public function addToCarts($id, $num, $type) {
        if($id) {
            $is = $this->where(array(
                'goods_id' => $id,
                'user_id' => getHomeUserID(),
                'type' => $type,
                'status' => 1
            ))->find();

//                ->save(array(
//                    'update_time' => time(),
//                    'status' => 2
//                ));
            if($is) {
                //修改
                $iss = $this->where(array(
                    'id' =>$is['id']
                ))
                ->save(array(
                    'update_time' => time(),
                    'num' => $is['num'] + $num
                ));

            } else {
                //添加
                $iss = $this
                    ->add(array(
                        'goods_id' => $id,
                        'user_id' => getHomeUserID(),
                        'num' => $num,
                        'update_time' => time(),
                        'type' => $type,
                        'status' => 1,
                    ));
            }
            if($iss !== false) {
                return true;
            }
        }
        return false;
    }



}

?>