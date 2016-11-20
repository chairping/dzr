<?php
namespace Home\Controller;
use Think\Controller;
class AddressController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
     * @author 曹梦瑶
     * 编辑收货地址
     */
    public function edit() {
        if(IS_POST){
            $data = I('post.');
            $UserShipingAddress = M('user_shiping_address');
            $UserShipingAddress->where(array('user_id' => session('id')))->save($data);

            $list['error'] = 0;
            echo json_encode($list);exit;
        }else {
            //找出当前用户最新的一个收货地址
//            session('id', '1');
            $address = D('UserShipingAddress')->getInfo();

            $this->assign('address', $address);

            $this->display('edit');
        }
    }

}