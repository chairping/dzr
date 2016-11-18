<?php
namespace Admin\Controller;
use Think\Controller;

class CronController extends Controller {
    private $order;
    public function __construct() {
        parent::__construct();
        $this->order = M('dzr_order');
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
   * @author 曹梦瑶
   * 定时脚本 发货7天后，自动变为已完成订单
   */
    public function refleshOrder() {
        $date_start = strtotime(date('Y-m-d H:i:s', strtotime('-7 days')));

        //查找 状态是 已发货 并且时间超过七天的
        $id_arr = $this->order->where(array(
            'create_time' => array('lt', $date_start),
            'deliver_status' => 3,
            'status' => 1
        ))
            ->getField('id', true);

        //更新order表信息 状态
        $is = $this->order->where(array(
            'id' => array('in', $id_arr)
        ))
            ->save(array(
                'deliver_status' => 4,
                'update_time' => time(),
            ));
        if($is !== false) {
            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ),
            "message" => '操作成功') );
        } else {
            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ),
                "message" => '操作失败') );
        }

    }

}
