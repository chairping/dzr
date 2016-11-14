<?php

namespace Admin\Model;

use Think\Model;
use Admin\Model\CommonModel;

class UserShipingAddressModel extends Model {
    protected $tableName = "user_shiping_address";

    /*
     * @author 曹梦瑶
     * 获取用户信息
     */
    public function getUserName($user_id_arr){
        $list = array();
        if($user_id_arr){
            $list = $this->where(array(
                'id' => array('in' , $user_id_arr),
                'user_id' => getHomeUserID(),
            ))
                ->getField('id, name', true);
        }
//        dd($list);
        return $list;
    }
}
?>