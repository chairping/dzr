<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class ActionHistoryModel extends CommonModel {
    protected $tableName = "action_history";


    public function getActionHistoryInfo($user_id) {
        $list = $this->where(array(
            'user_identify_id' => $user_id
        ))
            ->order('update_time desc')
//            ->limit($page)
            ->distinct(true)
            ->getField('spots_id', true);

        return $list;
    }

    public function getAllNum($user_id) {
        $list2 = $this
            ->alias( 'A' )
            ->join('sisa_shop_info B on B.id = A.spots_id ')
            ->where(array(
                'A.user_identify_id' => $user_id,
                'B.status' => 1,
            ))
->field(array('A.spots_id', 'A.id'))
->select();

            //->getField('A.spots_id,A.id', true);
$list = array_column($list2, 'spots_id');

        $list1 = array();
        foreach ($list as $k => $v) {
            if(!in_array($v, $list1)) {
                $list1[] = $v;
            }
        }
//dd($list1 ,$this->getLastSql());

        $num = 0;
        $num = count($list1);
        return $num;

    }
    public function getNum($user_id, $mark) {
        $list2 = $this
            ->alias( 'A' )
            ->join('sisa_shop_info B on B.id = A.spots_id ')

            ->where(array(
                'A.user_identify_id' => $user_id,
                'B.status' => 1,
                'B.shop_type_id' => $mark
            ))
->field(array('A.spots_id', 'A.id'))
->select();
            //->getField('A.spots_id', true);
$list = array_column($list2, 'spots_id');
        $list1 = array();
        foreach ($list as $k => $v) {
            if(!in_array($v, $list1)) {
                $list1[] = $v;
            }
        }


        $num = 0;
        $num = count($list1);
        return $num;

    }

    /*
     * @author 曹梦瑶
     * 通过用户唯一id 找最近一次扫描的店铺id
     */
    public function isIn($user_identify_id) {
        $spots_id = $this->where(array(
            'user_identify_id' => $user_identify_id
        ))
            ->order('update_time desc')
            ->getField('spots_id');
        return $spots_id;
    }

    public function addLogs($user_id, $spots_id) {
        $is = $this->where(array(
            'user_identify_id' => $user_id,
            'spots_id' => $spots_id,
        ))->find();

        //增加记录
        $this->add(array(
            'user_identify_id' => $user_id,
            'spots_id' => $spots_id,
            'uptate_time' => time()
        ));

        if($is) {
            //存在
            return false;
        } else {
            return true;
        }
    }

}

?>