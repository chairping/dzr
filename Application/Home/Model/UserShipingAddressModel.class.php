<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class UserShipingAddressModel extends CommonModel {
    protected $tableName = "user_shiping_address";

    /*
     * @author 曹梦瑶
     * 收货地址
     */
    public function getInfo() {
        $list = array();
        $user_id = getHomeUserID();
        if($user_id) {
            $list = $this->where(array(
                'user_id' => $user_id,
                'status' => 1,
            ))
                ->order('update_time desc')
                ->find();
        }
        return $list;

    }

}

?>