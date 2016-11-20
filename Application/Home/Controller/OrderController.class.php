<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
   * @author 曹梦瑶
   * 我的订单
   */
    public function index() {
        //查找出对应的有效订单
        $order_info = array();
        $order_info = D('Order')->getInfo();
        $goods_id_arr_all = array();
        //算出单价 以及修改价格
        foreach ($order_info as $k =>$v) {
            $order_info[$k]['sales_price'] = round($v['sales_price'] / 100, 2);
            //循环订单中的商品
            $goods_id_arr = explode(',', $v['goods_id']);
            $goods_id_arr_all = array_merge($goods_id_arr_all, $goods_id_arr);
            $per_price_arr = explode(',', $v['per_price']);
            $num = explode(',', $v['num']);
//            dd($num);
            $order_info[$k]['num'] = $num;
            $order_info[$k]['goods_id'] = $goods_id_arr;
            foreach ($goods_id_arr as $kk => $vv) {
                $order_info[$k]['per_money'][] = round($per_price_arr[$kk] / 100, 2);

            }


        }

        //获取商品名字、图片
        $goods_info = array();
        $goods_id_arr = array();
        $goods_id_arr = array_unique($goods_id_arr_all);
        $goods_id_arr && $goods_info = D('Goods')->getInfoByIdArr1($goods_id_arr);

        $this->assign('order_info', $order_info);
        $this->assign('goods_info', $goods_info);
        $this->assign('menu', 'order');
        $this->assign('deliver_status', C('DELIVER_STATUS'));
//dd($order_info,$goods_info);
        $this->display('myOrder');


    }

    /*
     * 添加付款订单信息
     * @params array(
     * 'goods_id', (逗号分隔)
     * 'num', (逗号分隔)
     * 'scenic_spots_id'
     * )
     */
    public function addOrder() {
        $is_real = false;
        $data = I('post.');
//        $data = array(
//            'goods_id' => '',
//            'num' => '',
//            'num' => '',
//        )
        $goods_id_arr = array_filter($data['goods_id']);
        $num_arr = array_filter($data['num']);
        $goods_info = D('Goods')->getInfoByIdArr($goods_id_arr);

        $per_price_str = '';
        $sales_price = 0;
        foreach($goods_id_arr as $k => $v) {
            $sales_price += $goods_info[$v]['price'] * 100 * $num_arr[$k];
            $per_price_str .= $goods_info[$v]['price'].',';
        }

        $add_params = array();
//        $sales_price = $goods_info['price'] * 100 * $data['num'];
        $add_params['sales_price'] = $sales_price;
        $add_params['scenic_spots_id'] = $data['scenic_spots_id'];
        $add_params['goods_id'] = $data['goods_id'];
        $add_params['num'] = $data['num'];
        $add_params['per_price'] = $per_price_str;
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
                $save_share_arr['money'] = round($sales_price * ($percent_arr['first_proportion'] + $percent_arr['this_proportion'])/100);
                $save_share_arr['share_proportion'] = $percent_arr['first_proportion'] + $percent_arr['this_proportion'];

                $is_real = D('RealShare')->RealShare->addShare($save_share_arr);
            }

        } else {
            //两种公司 4 6分
            //第一次的景点
            $save_share_arr['order_id'] = $order_id;
            $save_share_arr['spots_id'] = $first_spots_id;
            $save_share_arr['money'] = round($sales_price * ($percent_arr['first_proportion'])/100);
            $save_share_arr['share_proportion'] = $percent_arr['first_proportion'];

            $is_real1 = D('RealShare')->RealShare->addShare($save_share_arr);

            //当前的景点
            $save_share_arr['order_id'] = $order_id;
            $save_share_arr['spots_id'] = $data['scenic_spots_id'];
            $save_share_arr['money'] = round($sales_price * ($percent_arr['this_proportion'])/100);
            $save_share_arr['share_proportion'] = $percent_arr['this_proportion'];

            $is_real2 = D('RealShare')->RealShare->addShare($save_share_arr);

            if($is_real1 && $is_real2) {
                $is_real = true;
            }
        }
        //记录景点分红情况 --终

        if($is_real) {
            $this->ajaxReturn(
                array(
                    "statusCode" => C( 'SUC_CODE' ),
                    "message" => '操作成功',
                   ) );
        }
        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'订单生成失败'));
    }
    
    /*
     * @author 曹梦瑶
     * 确认收货
     */
    public function checkOrder() {
        $id = I('post.id');
        $is = D('Order')->checkOrder($id);
        if($is) {
            $this->ajaxReturn(
                array(
                    "statusCode" => C( 'SUC_CODE' ),
                    "message" => '操作成功',
                ) );
        }
        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'确认收货失败'));
    }


}