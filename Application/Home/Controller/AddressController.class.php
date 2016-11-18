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
        //找出当前用户最新的一个收货地址
        $address = D('UserShipingAddress')->getInfo();

        $this->assign('address', $address);

        $this->display('edit');

    }

}