<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class ScenicSpotsModel extends CommonModel {
    protected $tableName = "scenic_spots";

    /*
     * @author 曹梦瑶
     * 通过景点id 获取景点信息
     */
    public function getInfo($id) {
        $list = array();
        if($id) {
            $list = $this->where(array(
                'id' => $id
            ))
                ->getField('scenic_name');
        }

        return $list;
    }

        /*
     * @author 曹梦瑶
     * 通过景点id 获取景点信息
     */
    public function getInfoById($id) {
        $list = array();
        if($id) {
            $list = $this->where(array(
                'id' => $id
            ))
                ->getField('img_addr');
        }

        return $list;
    }





}

?>