<?php
    
namespace Admin\Model;

class OrderModel extends \Common\Model\BaseModel  {
    protected $tableName = "order";
    /*
     * @author 曹梦瑶
     * 通过景点id 获取信息
     */
    public function getInfoBySpots($scenic_spots_id) {
        $list = $this->where(array(
            'scenic_spots_id' => $scenic_spots_id,
            'status' => 1
        ))
            ->select();
//        dd($scenic_spots_id,$list, $this->getLastSql());
        return $list;
    }

   

}

