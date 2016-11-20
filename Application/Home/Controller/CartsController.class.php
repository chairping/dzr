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
        session('id', 1);       //测试
        session('scenic_spots_id', 1);       //测试
        //获取购物车中的商品信息
        $pro_id_arr = array_unique(array_column($carts_info, 'goods_id'));
        $goods_arr = D('Goods')->getInfoByIdArr1($pro_id_arr);

        //景区id
        $scenic_spots_id = session('scenic_spots_id');
        $this->assign('scenic_spots_id', $scenic_spots_id);
        $this->assign('carts_info', $carts_info);
        $this->assign('goods_arr', $goods_arr);
        $this->assign('menu', 'cart' );
//dd($carts_info,$goods_arr);
        $this->display('index');

//        $Mcar = M('carts');

//        $usercart = $Mcar->where(array('user_id' => session('id')))->select();
//        $goodID = array_column($usercart, 'goods_id');
//        $goodsInfo = D('Goods')->getInfoByIdArr($goodID);
////        dd(!$usercart);
//        $this->assign('goodsInfo', $goodsInfo);
//        $this->assign('usercart', $usercart);
//        $this->display('index');


    }

    /*
     * @author 曹梦瑶
     * 加入购物车
     */
    public function add() {
        $data = I('post.');
        $id = $data['id'];
        $num = $data['num'];
        $is = D('Carts')->addToCarts($id, $num);
        if($is) {
            $this->ajaxReturn(
                array(
                    "statusCode" => C( 'SUC_CODE' ),
                    "message" => '操作成功',
                ) );
        }
        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'加入购物车失败'));

    }

    /*
     * @author 曹梦瑶
     * 删除
     */
    public function delete() {
        $data = I('post.');

        $goods_id_arr = array_filter(explode(',', $data['check_num']));
        
        //修改购物车状态
        $is = D('Carts')->deleteByGoodsId($goods_id_arr);

        if($is) {
            $this->ajaxReturn(
                array(
                    "statusCode" => C( 'SUC_CODE' ),
                    "message" => '操作成功') );
        }

        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'修改信息失败'));
    }



}