<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class GoodsModel extends CommonModel {
    protected $tableName = "goods";

    /*
     * @author 曹梦瑶
     * 获取商品信息
     */
    public function getInfo() {
        $list = array();
        $list = $this->where(array(
            'status' => 1,
            'sale_status' => 1,
        ))
            ->order('update_time desc')
            ->select();

        return $list;
    }



}

?>