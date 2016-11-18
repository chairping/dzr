<?php
namespace Home\Controller;
use Think\Controller;
class CartsController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
     * @author 曹梦瑶
     * 购物车
     */
    public function index() {
        //查找出对应的有效购物车内容
        $carts_info = array();
        $carts_info = D('Carts')->getInfo();

        //获取购物车中的商品信息
        $pro_id_arr = array_unique(array_column($carts_info, 'goods_id'));
        $goods_arr = D('Goods')->getInfoByIdArr($pro_id_arr);

        $this->assign('carts_info', $carts_info);
        $this->assign('goods_arr', $goods_arr);

        $this->display('index');

    }

}