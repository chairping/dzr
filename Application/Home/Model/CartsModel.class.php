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
    public function getInfo() {
        $list = array();
        $user_id = getHomeUserID();
        if($user_id) {
            $list = $this->where(array(
                'user_id' => $user_id,
                'status' => 1
            ))
                ->order('update_time desc')
                ->select();
        }
        return $list;

    }


}

?>