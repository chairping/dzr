<?php
    
namespace Admin\Model;

class WithdrawModel extends \Common\Model\BaseModel  {

    /*
     * @author 曹梦瑶
     * 根据用户id 获取用户的提现信息
     */
    public function getPercentById($user_id) {
        $list = $this->where(array(
            'withdraw_user_id' => $user_id,
            'status' => 1))
            ->getField('id, money, withdraw_status', true);

        //整理
        $already = 0;
        $wait = 0;
        foreach ($list as $k => $v) {
            if($v['withdraw_status'] == 1) {
                $wait += $v['money'];
            } else {
                $already += $v['money'];
            }
        }
//        dd(array('already'=>$already, 'wait' => $wait), $this->getLastSql());
        return array('already'=>$already, 'wait' => $wait);


    }

    /*
    * @author 曹梦瑶
    * 新增提现
    */
    public function addNewOrder($withdraw_data, $type, $money) {
        $params = array(
            'withdraw_user_id' => getHomeUserID(),
            'money' => $money * 100,
            'withdraw_status' => 1,
            'update_time' => time(),
            'status' => 1,
            'withdraw_data' => json_encode($withdraw_data),
            'withdraw_type_id' => $type
        );

        $is = $this->add($params);
        if($is) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取申请提现列表
     * @param array $where
     * @param $page
     * @param $pageSize
     */
    public function getInfoList($where= [], $pageIndex, $pageSize) {


        $count= $this->where($where)->count();

        if($count < $pageIndex* $pageSize){
            $pageIndex= intval($count/$pageSize) + (($count % $pageSize > 0) ? 1 : 0);
        }


        $data = $this->join('dzr_admin_info on dzr_admin_info.id=dzr_withdraw.withdraw_user_id', 'LEFT')
            ->where($where)
            ->page($pageIndex, $pageSize)
            ->field('dzr_withdraw.money,dzr_withdraw.id, dzr_withdraw.update_time,dzr_admin_info.username,dzr_admin_info.scenic_spots_id')
            ->select();

        return compact('data', 'count');
    }

    public function check($id, $data = []) {
        $data['update_time'] = time();
        $data['withdraw_status'] = 2;

        return $this->where(['id' => $id])->save($data);
    }

}

