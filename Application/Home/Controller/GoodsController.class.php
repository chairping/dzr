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
     * params array('id', 'num')
     */
    public function buy() {
        if(IS_POST) {


        } else {
            $data = I('get.');
            $id = $data['id'];
            $num = $data['num'];

            //查找商品信息
            $goods_info = D('Goods')->getInfoById($id);
            $price = $num * $goods_info['price'];
            
            //找出当前用户最新的一个收货地址
            $address = D('UserShipingAddress')->getInfo();

            $this->assign('id', $id);
            $this->assign('num', $num);
            $this->assign('all_price', $price);
            $this->assign('address', $address);

            $this->display('buy');
//            $this->ajaxReturn( array(
//                "statusCode" => C( 'SUC_CODE' ),
//                "id" => $id,
//                "num" => $num,
//                "all_price" => $price,
//                'url' => __ROOT__.'/index.php/Goods/checkBuy') );
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