<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class IntegralSortModel extends CommonModel {
    protected $tableName = "integral_sort";

    /*
     * @author 曹梦瑶
     * 获取有效的兑换分类
     */
    public function getInfo() {
        $list =array();
        $list = $this->where(array(
            'status' => 1
        ))
            ->order('update_time desc')
            ->getField('id, name', true);
        return $list;
    }

    /*
     * @author 曹梦瑶
     * 获取分类名称
     */
    public function getNameById($id) {
        $name = '';
        if($id) {
            $name = $this->where(array(
                'id' => $id
            ))
                ->getField('name');

        }
        return $name;
    }
}

?>