<?php
    
namespace Admin\Model;

class ScenicSpotsModel extends \Common\Model\BaseModel  {

    public function edit($id, $data) {

        if ($id) {
            return $this->where(['id' => $id])->save($data);
        }

        return false;
    }
}

