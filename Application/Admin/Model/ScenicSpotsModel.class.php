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

    /**
     * 景区销售金额统计
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function scenicsSale($page, $pageSize) {
        $count= $this->count();

        if($count < $page * $pageSize){
            $page = intval($count/$pageSize) + (($count % $pageSize > 0) ? 1 : 0);
        }

        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));

        $data = $this->query(
            "select s.*,IFNULL(sum(o.sales_price),0) as total, sum(if ((o.update_time >" . $start . " and o.update_time < " . $end ."), sales_price, 0)) as today_total 
 from dzr_scenic_spots as s left join dzr_order as o on
  s.id = o.scenic_spots_id and s.status=1  GROUP BY s.id limit " . ($page) * $pageSize. "," . $pageSize
        );

        return compact('data', 'count');

    }



}

