<?php
    
namespace Admin\Model;

class GoodsModel extends \Common\Model\BaseModel  {

    public function edit($id, $data) {

        if ($id) {
            return $this->where(['id' => $id])->save($data);
        }

        return false;
    }

    /*
     * @author 曹梦瑶
     * 获取信息
     */
    public function getGoodsName($goods_id_arr){
        if($goods_id_arr){
            $list = $this->where(array(
                'id' => array('in' , $goods_id_arr),
                'status' => 1
            ))
                ->getField('id, title', true);
            return $list;
        }
        return false;
    }
}

