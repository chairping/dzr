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
            $data['user_id'] = getHomeUserID();
//            dd($_SERVER);
            $data['update_time'] = $_SERVER['REQUEST_TIME'];
            $UserShipingAddress = M('user_shiping_address');
            $is = $UserShipingAddress->add($data);
//            dd($UserShipingAddress->getLastSql());
            if($is) {
                $list['error'] = 0;
            } else {
                $list['error'] = 1;
            }

            echo json_encode($list);exit;
        }else {
            //找出当前用户最新的一个收货地址
//            session('id', '1');

            $url = urldecode(I('get.url'));
//            dd('__ROOT__/index.php/Self/index', $url);
            $address = D('UserShipingAddress')->getInfo();

            $this->assign('address', $address);
            $this->assign('url', $url);
//            dd($url);

            $this->display('edit');
        }
    }

}