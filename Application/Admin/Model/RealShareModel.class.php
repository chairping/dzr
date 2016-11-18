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

}

