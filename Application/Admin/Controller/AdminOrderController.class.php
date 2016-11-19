<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/11
 * Time: 22:22
 */

namespace Admin\Controller;

use Common\Controller\AdminController;
use Common\Lib\Base64Image;

class AdminOrderController extends AdminController
{

    public $OrderModel;

    public function _initialize() {
        $this->OrderModel= D('Order');
    }

    public function index() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $where = array(
            'status'=> 1
        );

        if(I('deliver_status')) {
            $where['deliver_status'] = I('deliver_status');
        }

        $data = $this->OrderModel->getListWithCount($where, $page, $pageSize, 'create_time desc');

        $goodsList = $data['data'];
//        dump($goodsList);
        array_walk($goodsList, function(&$row) {
            $row['single_price'] = formatMoney($row['sales_price']/$row['num'], true);
            $row['sales_price'] = formatMoney($row['sales_price'], true);
            $row['create_time'] = date("Y-m-d H:i:s", $row['create_time']);

            $goodsInfo = D('Goods')->find($row['goods_id']);
            $row['goods_name'] = $goodsInfo['title'];

            $sportInfo = D('ScenicSpots')->find($row['scenic_spots_id']);
            $row['scenic_name'] = $sportInfo['scenic_name'];
        });
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

//        $this->assign('to_complete_url', cp_U("AdminOrder/index", array_merge(I('get.'), array('type'=> 1))));
//        $this->assign('ing_complete_url', cp_U("AdminOrder/index", array_merge(I('get.'), array('type' => 2))));
//        $this->assign('complete_url', cp_U("AdminOrder/index", array_merge(I('get.'), array('type' => 3))));

        $this->assign('type', I('type', 1, 'intval'));

        $this->assign('status', [
            1=>'自取',
            2=>'未发货',
            3=>'已发货',
            4 =>'已收货'
        ]);

        $this->assign('data', $goodsList );
        $this->display();
    }

    public function addCompany() {

        $id = I('id', 0, 'intval');

        if (!$id) {

            $this->ajaxReturn([
                'code' => 0,
                'msg' => '非法访问'
            ]);
        }
//
        $logistics_company = I('logistics_company');
        $courier_number = I('courier_number');

        if (!$logistics_company) {

            $this->ajaxReturn([
                'code' => 0,
                'msg' => '快递公司必需填写'
            ]);
        }

        if (!$courier_number) {

            $this->ajaxReturn([
                'code' => 0,
                'msg' => '快递单号必需填写'
            ]);
        }

        $deliver_status = 3;

        $status = $this->OrderModel->where(['id' => $id])->save(compact('logistics_company', 'courier_number', 'deliver_status'));

        if (!$status) {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '操作失败'
            ]);
        } else {
            $this->ajaxReturn([
                'code' => 1,
                'msg' => '操作成功'
            ]);
        }

    }

    public function getUserShopingInfo() {
        $userId = I('user_id');

        $info = D('UserShipingAddress')->where(['user_id' => $userId, 'address_type' => 1])->find();

        $this->ajaxReturn($info);
    }

}
