<?php
    
namespace Admin\Model;

class ScenicSpotsModel extends \Common\Model\BaseModel  {

    public function edit($id, $data) {

        if ($id) {
            return $this->where(['id' => $id])->save($data);
        }

        return false;
    }

    /*
     * @author 曹梦瑶
     * 获取代理景点信息
     */
    public function getInfoById($id) {
        $list = $this->where(array('id' => $id, 'status' => 1))->find();
        return $list;
    }

}

