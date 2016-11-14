<?php
    
namespace Admin\Model;

class WithdrawProportionModel extends \Common\Model\BaseModel  {

    /*
     * @author 曹梦瑶
     * 根据用户类型 获取用户的分红提现百分比
     */
    public function getPercentById($type) {
        $withdraw_proportion = $this->where(array(
            'type' => $type,
            'status' => 1))
            ->order('update_time desc')
            ->getField('withdraw_proportion');
        $withdraw_proportion = $withdraw_proportion ? $withdraw_proportion : 0;
//        dd($withdraw_proportion, $this->getLastSql());
        return $withdraw_proportion;
    }

}

