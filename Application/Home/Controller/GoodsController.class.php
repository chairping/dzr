<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
     * @author 曹梦瑶
     * 商品信息详情
     * get array('goods_id','scenic_spots_id')
     */
    public function index() {
        $data = I('get.');
//        dd($data);
        $goods_id = $data['goods_id'];
        $scenic_spots_id = $data['scenic_spots_id'];
        if($goods_id) {
            $goods_info = D('Goods')->getInfoById($goods_id);
            if(!$goods_info) {
                $this->display('notFind');
            } else {
                //通过景区id 查找景区图片
                $spots_img_addr = D('ScenicSpots')->getInfoById($scenic_spots_id);
//dd(D('Goods')->getLastSql(),$goods_info);
                $this->assign('scenic_spots_id', $scenic_spots_id);
                $this->assign('goods_info', $goods_info);
                $this->assign('spots_img_addr', $spots_img_addr);
                $this->display('index');
            }

        } else {
            $this->display('notFind');
        }
    }

    /*
     * @author 曹梦瑶
     * 点击购买商品
     * params array('id', 'num', 'scenic_spots_id')
     */
    public function buy() {
        if(IS_POST) {


        } else {
            session('id', 1);    //测试
            $data = I('get.');

            $id = array_filter(array_unique(explode(',', $data['id'])));
            $num_or = array_filter(explode(',', $data['num']));
            $scenic_spots_id = $data['scenic_spots_id'];
            if(strpos($data['id'], ',') === false){     //使用绝对等于
                //不包含
                $num = $num_or;
                $mark = 1;
            }else{
                $mark = 2;
                //包含
                $carts_info = D('Carts')->getInfo();
                $id_arr = array_column($carts_info, 'id');
                //整理数组
                $new_arr = array();
                $num = array();
                foreach ($id_arr as $k => $v) {
                    if(in_array($v, $id)) {
                        $new_arr[$v] = $num_or[$k];
                        $num[] = $num_or[$k];
                    }

                }

//                dd($id,$new_arr);
            }


//dd($mark);

            //查找商品信息
            $price = 0;
            $per_all_price = array();
            $goods_info = D('Goods')->getInfoByIdArr($id);
           foreach ($goods_info as $k => $v) {

               $price += $num[$k] * $v['price'];
               $per_all_price[$k] = $num[$k] * $v['price'];
           }
            
//            //找出当前用户最新的一个收货地址
//            $address = D('UserShipingAddress')->getInfo();

            $this->assign('goods_info', $goods_info);
//      dd(D('Goods')->getLastSql(),$goods_info,$num,$per_all_price,$price);
            $this->assign('num', $num);
            $this->assign('price', $per_all_price);
            $this->assign('all_price', $price);
            $this->assign('scenic_spots_id', $scenic_spots_id);
            $this->assign('mark', $mark);
//            $this->assign('address', $address);

            $this->display('buy');
        }


    }

    /*
     * @author 曹梦瑶
     * 确认购买
     */
    public function checkBuy() {
        if(IS_POST) {
            //(微信支付接口)  还没做

        } else {
            $this->display('checkBuy');
        }
    }

}