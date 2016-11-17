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

    /*
     * @author 曹梦瑶
     * 根据产品id 获得产品信息
     */
    public function getInfoById($id) {
        $list = array();
        if($id) {
            $list = $this->where(array('id' => $id))->find();
        }
      return $list;
    }

    /*
     * @author 曹梦瑶
     * 根据产品id 获得产品信息
     */
    public function getInfoByIdArr($id_arr) {
        $list = array();
        if($id_arr) {
            $list = $this->
            where(array('id' => array('in', $id_arr)))
                ->getField('id, title, cover_img_addr', true);
        }
      return $list;
    }



}

?>