<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class RealShareModel extends CommonModel {
    protected $tableName = "real_share";

    /*
     * @author 曹梦瑶
     * 添加分成
     */
    public function addShare($data) {
        $data['update_time'] = time();
        $data['status'] = 1;
        $is = $this->add($data);
        if($is) {
            return true;
        } else {
            return false;
        }
    }

}

?>