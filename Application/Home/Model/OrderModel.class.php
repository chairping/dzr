<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class OrderModel extends CommonModel {
    protected $tableName = "order";

    /*
     * @author 曹梦瑶
     * 添加订单
     */
    public function addOrder($data) {
        $data['user_id'] = getHomeUserID();
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['status'] = 1;

        $id = $this->add($data);
        return $id;

    }

    /*
   * @author 曹梦瑶
   * 查找出对应的有效订单
   */
    public function getInfo() {
        $list = array();
        $user_id = getHomeUserID();
        if($user_id) {
            $list = $this->where(array(
                'user_id' => $user_id,
                'status' => 1
            ))
                ->order('id desc')
                ->select();
        }
        return $list;

    }

    /* @author 曹梦瑶
    * 确认收货
    */
    public function checkOrder($id) {
        $is = $this->where(array(
            'id' => $id
        ))
            ->save(array(
                'deliver_status' => 4,
                'update_time' => time(),
            ));

        if($is !== false) {
            return true;
        } else {
            return false;
        }


    }


}

?>