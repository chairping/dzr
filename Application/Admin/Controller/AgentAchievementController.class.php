<?php
namespace Admin\Controller;
use Common\Controller\AgentController;

class AgentAchievementController extends AgentController{
    public function __construct() {
        parent::__construct();
    }

    /*
     * @author 曹梦瑶
     * 业绩列表
     */
    public function index(){
        $id = getHomeUserID();
        //获取个人信息
        $user_info = D('AdminInfo')->getInfo($id);
//        $scenicId = M('admin_info')->where($con)->getField('scenic_spots_id');

        //获取代理景区信息
        $scenic_spots_id = $user_info['scenic_spots_id'];
        $spots_info = D('ScenicSpots')->getInfoById($user_info['scenic_spots_id']);
//        $scenicName = M('scenic_spots')->where(array('id' => $scenicId))->getField('scenic_name');  //代理景区名

        $type = $user_info['type'] ;    //用户类型
        //根据用户类型 获取用户的分红提现百分比
        $withdraw_proportion = D('WithdrawProportion')->getPercentById($type);
//        dd(D('WithdrawProportion')->getLastSql());
        //判断用户类型
        if($user_info['type'] == 2) {
            //一级代理用户 分红只有这一个人
            $person = 1;

        } else {
            //农民 多个人 取平均值
            //获取用户所属景区的有效农民总个数

            $person = D('AdminInfo')->getPersonNumBySpots($scenic_spots_id);
            $person = $person ? $person: 1;
//dd($person);
        }

        //获取景点的订单信息 --始
        $order_info = D('Order')->getInfoBySpots($scenic_spots_id);
        //获取订单中产品的信息
        $good_id_arr = array_column($order_info, 'goods_id');
        $goods_name_arr = D('Goods')->getGoodsName($good_id_arr);

        //获取用户信息
        $user_id_arr = array_column($order_info, 'ship_id');
        $user_name_arr = D('UserShipingAddress')->getUserName($user_id_arr);

        //总销售额
        $all_sales_price = 0;
        foreach ($order_info as $k => $v) {
            $all_sales_price += $v['sales_price'];
        }
//        dd($all_sales_price);

        //销售总提成
        //提成被除数
        $withdraw_num = 100 * $person;
//        $all_withdraw_price = round($all_sales_price * $withdraw_proportion / $withdraw_num);
        //获取真正能够拿到的总提成（这个月之前的总和）
        $all_money =  D('RealShare')->getPercentById($scenic_spots_id);
        $all_withdraw_price = round($all_money * $withdraw_proportion / $withdraw_num);

//        dd($all_sales_price, $withdraw_proportion,$withdraw_num );
        //获取景点的订单信息 --终

        //获取登录用户的提成信息 --始
        $withdraw_info = D('Withdraw')->getPercentById($id);

        //可提现金额
        $avaible_money = $all_withdraw_price - $withdraw_info['already'] - $withdraw_info['wait'];
        //获取登录用户的提成信息 --终


//        $map['status'] = 1;
//        $map['scenic_spots_id'] = $scenicId;
//        $orderInfo = M('order')->where($map)->select();

//        $goodNameId = array_column($orderInfo, 'goods_id');
//        $goodsName = D('Goods')->getGoodsName($goodNameId);
//        foreach ($orderInfo as $k=>$v){
//            $orderInfo[$k]['goods_id'] = $goodsName[$v['goods_id']] ? $goodsName[$v['goods_id']] : '--';
//        }

//        $userNmaeId = array_column($orderInfo, 'user_id');
//        $userName = D('UserShipingAddress')->getUserName($userNmaeId);
//        foreach ($orderInfo as $k=>$v){
//            $orderInfo[$k]['user_id'] = $userName[$v['user_id']] ? $userName[$v['user_id']] : '--';
//        }
//        $withdraw = M('withdraw_proportion')->getField('withdraw_proportion');
//        $allSalesPrice = M('order')->where($con)->sum('sales_price');   //总销售额
//        $allWithdrawPrice = $allSalesPrice * $withdraw / 100 ;   //销售总提成

        $this->assign('order_info', $order_info);
//        dd($order_info);
        $this->assign('spots_info', $spots_info);
        $this->assign('goods_name_arr', $goods_name_arr);
        $this->assign('user_name_arr', $user_name_arr);
        $this->assign('all_sales_price', round($all_sales_price / 100, 2));
        $this->assign('all_withdraw_price', round($all_withdraw_price / 100, 2));
        $this->assign('withdraw_info', $withdraw_info);
        $this->assign('avaible_money', round($avaible_money / 100, 2));
        $this->assign('withdraw_num', $withdraw_num);
        $this->assign('withdraw_proportion', $withdraw_proportion);
        $this->display('index');
    }

    /*
     * @author 曹梦瑶
     * 申请提现
     */
    public function apply() {
//        dd(mktime(0,0,0,date('m'),1,date('Y')));
        if(IS_POST) {
            $post = I('post.');
//            dd($post);
            $user_id = getHomeUserID();
            $money = $post['user_withdraw'];
            $type = $post['pay_way_num'];

            if($type == 1) {
                //支付方式是银行卡
//                $bank_name = $post['bank_name'];
//                $bank_user_name = $post['bank_user_name'];
//                $bank_account = $post['bank_account'];
//                $bank_branches = $post['bank_branches'];
                $withdraw_data = array(
                    'bank_name' =>  $post['bank_name'],
                    'bank_user_name' =>  $post['bank_user_name'],
                    'bank_account' =>  $post['bank_account'],
                    'bank_branches' =>  $post['bank_branches'],
                );

            } elseif ($type == 2) {
                //支付方式是微信
//                $weixin_account = $post['weixin_account'];
                $withdraw_data = array(
                    'weixin_account' =>  $post['weixin_account'],
                );
            } else {
                //支付方式是支付宝
//                $alipay_acount = $post['alipay_acount'];
                $withdraw_data = array(
                    'alipay_acount' =>  $post['alipay_acount'],
                );
            }

            //将提现申请添加到order表
            $is = D('Withdraw')->addNewOrder($withdraw_data, $type, $money);
//            dd($is,  D('Order')->getLastSql());
            if($is) {
                //修改用户的支付方式
                $iss = D('AdminInfo')->saveInfoById(getHomeUserID(), $withdraw_data);
                if($iss) {
                    $this->ajaxReturn(
                        array(
                            "statusCode" => C( 'SUC_CODE' ),
                            "message" => '操作成功',
                            ) );
                }
            }
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'提现失败'));


        } else {
            $id = getHomeUserID();
            //获取个人信息
            $user_info = D('AdminInfo')->getInfo($id);

            //获取代理景区信息
            $scenic_spots_id = $user_info['scenic_spots_id'];

            $type = $user_info['type'] ;    //用户类型
            //根据用户类型 获取用户的分红提现百分比
            $withdraw_proportion = D('WithdrawProportion')->getPercentById($type);
            //判断用户类型
            if($user_info['type'] == 2) {
                //一级代理用户 分红只有这一个人
                $person = 1;

            } else {
                //农民 多个人 取平均值
                //获取用户所属景区的有效农民总个数
                $person = D('AdminInfo')->getPersonNumBySpots($scenic_spots_id);
                $person = $person ? $person: 1;
            }

            //获取景点的订单信息 --始
            $order_info = D('Order')->getInfoBySpots($scenic_spots_id);

            //总销售额
            $all_sales_price = 0;
            foreach ($order_info as $k => $v) {
                $all_sales_price += $v['sales_price'];
            }

            //销售总提成
            //提成被除数
            $withdraw_num = 100 * $person;
//            $all_withdraw_price = round($all_sales_price * $withdraw_proportion / $withdraw_num);
            $all_money =  D('RealShare')->getPercentById($scenic_spots_id);
            $all_withdraw_price = round($all_money * $withdraw_proportion / $withdraw_num);
            //获取景点的订单信息 --终

            //获取登录用户的提成信息 --始
            $withdraw_info = D('Withdraw')->getPercentById($id);

            //可提现金额
            $avaible_money = $all_withdraw_price - $withdraw_info['already'] - $withdraw_info['wait'];
            //获取登录用户的提成信息 --终

            //获取用户提成方式
            $withdraw_way = D('AdminInfo')->getWithdraw();
            
            //默认支付方式是银行卡
            $pay_way = D('AdminInfo')->getBankInfo();

            $pay_way_num = 1;
//dd($pay_way);
            $this->ajaxReturn( array(
                "statusCode" => C( 'SUC_CODE' ),
                "avaible_money" => round($avaible_money/100, 2),
                'withdraw_way' => $withdraw_way,
                'pay_way' => $pay_way,
                'pay_way_num' => $pay_way_num,
            ));
        }
    }

    /*
     * @author 曹梦瑶
     * 修改提现方式
     */
    public function changePayWay() {
        $pay_way_num = I('post.way');
;
        if($pay_way_num == 1) {
            //支付方式是银行卡
            $pay_way = D('AdminInfo')->getBankInfo();

        } elseif ($pay_way_num == 2) {
            //支付方式是微信
            $pay_way = D('AdminInfo')->getWeixinInfo();
        } else {
            //支付方式是支付宝
            $pay_way = D('AdminInfo')->getAlipayInfo();
        }


//dd($pay_way_num,$pay_way);
        $this->ajaxReturn( array(
            "statusCode" => C( 'SUC_CODE' ),
            'pay_way' => $pay_way,
            'pay_way_num' => $pay_way_num,
        ));
    }


}
