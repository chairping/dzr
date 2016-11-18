<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class ShareProportionModel extends CommonModel {
    protected $tableName = "share_proportion";

    /*
     * @author 曹梦瑶
     * 获取分成
     */
    public function getInfo() {
        $list = $this->where(array(
            'status' => 1
        ))
            ->order('id desc')
            ->find();

        return $list;
    }

}

?>