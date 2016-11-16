<?php
namespace Home\Controller;
use Think\Controller;
class ShopController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
     * 添加付款订单信息
     * @params array(
     * 'goods_id',
     * 'num',
     * 'scenic_spots_id'
     * )
     */
    public function addOrder() {
        $is_real = false;
        $data = I('post.');
//        $morder = M('order');
//        $mgoods = M('goods');
        $goods_info = D('Goods')->getInfoById($data['goods_id']);
        $add_params = array();
//        $mgoods->where(array('id' => $data['goods_id']))->find();
        $sales_price = $goods_info['price'] * 100 * $data['num'];
        $add_params['sales_price'] = $sales_price;
        $add_params['scenic_spots_id'] = $data['scenic_spots_id'];
        $add_params['goods_id'] = $data['goods_id'];
        $add_params['num'] = $data['num'];
//        $data['user_id'] = getHomeUserID();
//        $data['create_time'] = time();
//        $data['update_time'] = time();
        //添加订单 返回订单id
        $order_id = D('Order')->addOrder($data);

        if(!$order_id) {
            //订单添加失败
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'订单添加失败'));
        }

        //记录景点分红情况 --始
        //查找用户第一次购买东西的景点
        $first_spots_id = D('UserInfo')->getSpotsIdById();
        $user_id = getHomeUserID();
        $save_share_arr = array();
        //获取景点分成
        $percent_arr = D('ShareProportion')->getInfo();

        if(0 == $first_spots_id) {
            //第一次购买东西 分红为该景点所有
            //将景点信息存入用户表
            $save_user_data = array();
            $save_user_data['first_spots_id'] = $data['scenic_spots_id'];
            $is_add = D('UserInfo')->saveInfoById($user_id, $save_user_data);
            if($is_add) {
                //添加分成
                $save_share_arr['order_id'] = $order_id;
                $save_share_arr['spots_id'] = $data['scenic_spots_id'];
                $save_share_arr['money'] = $sales_price * ($percent_arr['first_proportion'] + $percent_arr['this_proportion'])/100;
                $save_share_arr['share_proportion'] = $percent_arr['first_proportion'] + $percent_arr['this_proportion'];

                $is_real = D('RealShare')->RealShare->addShare($save_share_arr);

            }

        } else {
            //两种公司 4 6分
             

        }


        //记录景点分红情况 --终




//        $morder->add($data);
    }

}