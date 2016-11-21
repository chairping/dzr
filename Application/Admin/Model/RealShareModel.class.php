<?php
    
namespace Admin\Model;

class RealShareModel extends \Common\Model\BaseModel  {
    protected $tableName = "real_share";

    /*
     * @author 曹梦瑶
     * 根据景点id 获取这个月以前的销售
     */
    public function getPercentById($spots_id) {
        $list = $this->where(array(
            'spots_id' => $spots_id,
            'status' => 1,
            'update_time' => array('lt', mktime(0,0,0,date('m'),1,date('Y'))),
        ))
            ->getField('id, money, share_proportion', true);

        //整理
        $money = 0;
        foreach ($list as $k => $v) {
            $money += $v['money'];

        }
//        dd(array('already'=>$already, 'wait' => $wait), $this->getLastSql());
        return $money;
    }

    /*
     * @author 曹梦瑶
     * 通过order_id 获取 销售额
     */
    public function getSales($order_id_arr, $spots_id) {
        $list = array();

        if($order_id_arr) {
            $list1 = $this->where(array(
                'order_id' => array('in', $order_id_arr),
                'spots_id' => $spots_id,
                'status' => 1,
            ))
                ->getField('order_id, money', true);
//            dd( $list['sale']);
            $list['sale'] = array();
            $list['sale_all_money'] = 0;
            foreach ($list1 as $k => $v) {
                $temp = round($v/100, 2);
                $list['sale'][$k] = $temp;
                $list['sale_all_money'] += $temp;
            }
        }

        return $list;
    }

}

