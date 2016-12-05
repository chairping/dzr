<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class UserInfoModel extends CommonModel {
    protected $tableName = "user_info";

    /*
     * @author 曹梦瑶
     * 根据用户id 查找景点id
     */
    public function getSpotsIdById() {
        $spots_id = $this->where(array(
            'id' => getHomeUserID()
        ))
            ->getField('first_spots_id');

        return $spots_id;
    }

    /*
     * @author 曹梦瑶
     * 根据id 保存信息
     */
    public function saveInfoById($id, $data) {
        $data['update_time'] = time();
        $is = $this->where(array(
            'id' => $id
        ))
            ->save($data);
        if($is !== false) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * @author 曹梦瑶
     * 获取用户积分
     */
    public function getIntegral() {
        $user_id = getHomeUserID();
        $integral = 0;
        $integral = $this->where(array(
            'id' => $user_id
        ))
            ->getField('integral');
        return $integral;
    }

}

?>